<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @var string|null Password
     */
    public $password;

    /**
     * @var string|null Repeat password
     */
    public $repassword;

    /** Inactive status */
    const STATUS_INACTIVE = 0;
    /** Active status */
    const STATUS_ACTIVE = 1;
    /** Banned status */
    const STATUS_BANNED = 2;
    /** Deleted status */
    const STATUS_DELETED = 3;

    const ROLE_USER = 0;
    const ROLE_ADMIN = 1;

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'admin-create' => ['username', 'email', 'password', 'repassword', 'status', 'role'],
            'admin-update' => ['username', 'email', 'password', 'repassword', 'status', 'role']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['password', 'repassword'], 'required', 'on' => ['admin-create']],
            [['password', 'repassword'], 'string', 'min' => 4, 'max' => 30],
            [['role', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['email'], 'unique'],
            [['email'], 'email'],
            ['repassword', 'compare', 'compareAttribute' => 'password'],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => array_keys(self::getStatusArray())],

            ['role', 'default', 'value' => self::ROLE_USER],
            ['role', 'in', 'range' => array_keys(self::getRoleArray())],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin', 'ID'),
            'username' => Yii::t('admin', 'Username'),
            'auth_key' => Yii::t('admin', 'Auth Key'),
            'password_hash' => Yii::t('admin', 'Password Hash'),
            'password_reset_token' => Yii::t('admin', 'Password Reset Token'),
            'email' => Yii::t('admin', 'Email'),
            'role' => Yii::t('admin', 'Role'),
            'status' => Yii::t('admin', 'Status'),
            'created_at' => Yii::t('admin', 'Created At'),
            'updated_at' => Yii::t('admin', 'Updated At'),
            'password' => Yii::t('admin', 'Password'),
            'repassword' => Yii::t('admin', 'Repassword')
        ];
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN && $this->status === self::STATUS_ACTIVE;
    }

    public static function getRoleArray()
    {
        return [
            self::ROLE_USER => Yii::t('admin', 'ROLE_USER'),
            self::ROLE_ADMIN => Yii::t('admin', 'ROLE_ADMIN'),
        ];
    }

    /**
     * @return array Status array.
     */
    public static function getStatusArray()
    {
        return [
            self::STATUS_INACTIVE => Yii::t('admin', 'STATUS_INACTIVE'),
            self::STATUS_ACTIVE => Yii::t('admin', 'STATUS_ACTIVE'),
            self::STATUS_BANNED => Yii::t('admin', 'STATUS_BANNED'),
            self::STATUS_DELETED => Yii::t('admin', 'STATUS_DELETED'),
        ];
    }

    /**
     * @return string Model status.
     */
    public function getStatus()
    {
        $statuses = self::getStatusArray();
        return $statuses[$this->status];
    }

    /**
     * @return string Model role.
     */
    public function getRole()
    {
        $roles = self::getRoleArray();
        return $roles[$this->role];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = date("Y-m-d H:i");
                // Set default status
                if (!$this->status) {
                    $this->status = self::STATUS_ACTIVE;
                }
                // Set default role
                if (!$this->role) {
                    $this->role = self::ROLE_USER;
                }
                // Generate auth and secure keys
                $this->generateAuthKey();
            }
            if ($this->isNewRecord || (!$this->isNewRecord && $this->password)) {
                $this->setPassword($this->password);
                $this->generateAuthKey();
            }
            $this->updated_at = date("Y-m-d H:i");
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Change user password.
     *
     * @return boolean true if password was successfully changed
     */
    public function password($password)
    {
        $this->setPassword($password);
        return $this->save(false);
    }

    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['id' => 'order_id'])->viaTable('order_has_user', ['user_id' => 'id']);
    }
}