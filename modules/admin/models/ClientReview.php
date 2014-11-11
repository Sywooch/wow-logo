<?php

namespace app\modules\admin\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "client_review".
 *
 * @property integer $id
 * @property string $name
 * @property string $position
 * @property string $comment
 * @property string $site_link
 * @property string $logo_url
 * @property string $client_image_url
 * @property string $created_at
 * @property integer $is_published
 */
class ClientReview extends \yii\db\ActiveRecord
{
    public $logo;
    public $clientImage;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_review';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'position', 'comment', 'site_link', 'logo_url', 'client_image_url', 'created_at'], 'required'],
            [['logo', 'clientImage'], 'required', 'on' => ['create']],
            [['comment'], 'string'],
            [['is_published'], 'integer'],
            [['created_at'], 'safe'],
            [['logo', 'clientImage'], 'safe'],
            [['logo', 'clientImage'], 'file', 'extensions'=>'jpg, gif, png'],
            [['name', 'position', 'site_link'], 'string', 'max' => 255],
            [['site_link'], 'url'],
            [['logo_url', 'client_image_url'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin', 'ID'),
            'name' => Yii::t('admin', 'Name'),
            'position' => Yii::t('admin', 'Position'),
            'comment' => Yii::t('admin', 'Comment'),
            'site_link' => Yii::t('admin', 'Site Link'),
            'logo_url' => Yii::t('admin', 'Logo Url'),
            'logo' => Yii::t('admin', 'Logo Url'),
            'client_image_url' => Yii::t('admin', 'Client Image Url'),
            'clientImage' => Yii::t('admin', 'Client Image Url'),
            'created_at' => Yii::t('admin', 'Created At'),
            'is_published' => Yii::t('admin', 'Is Published'),
        ];
    }

    public function getImageFile($attribute)
    {
        $path = Yii::$app->basePath . Yii::$app->params['uploadPathClientReview'];
        if ($attribute == 'logo') {
            return isset($this->logo_url) ? $path . $this->logo_url : null;
        } else {
            return isset($this->client_image_url) ? $path . $this->client_image_url : null;
        }
    }

    public function getImageUrl($attribute)
    {
        $noImage = '/404.png';
        $url = Yii::$app->urlManager->baseUrl . Yii::$app->params['uploadUrlClientReview'];
        if ($attribute == 'logo') {
            return isset($this->logo_url) ? $url . $this->logo_url : $noImage;
        } else {
            return isset($this->client_image_url) ? $url . $this->client_image_url : $noImage;
        }
    }

    public function uploadImage($attribute)
    {
        $image = UploadedFile::getInstance($this, $attribute);
        if (empty($image)) {
            return false;
        }
        $fileNameArr = explode(".", $image->name);
        $ext = end($fileNameArr);
        if ($attribute == 'logo') {
            $this->logo_url = Yii::$app->security->generateRandomString().".{$ext}";
        } else {
            $this->client_image_url = Yii::$app->security->generateRandomString().".{$ext}";
        }
        return $image;
    }

    public function deleteImage($attribute)
    {
        $file = $this->getImageFile($attribute);
        if (empty($file) || !file_exists($file)) {
            return false;
        }
        if (!unlink($file)) {
            return false;
        }
        return true;
    }
}
