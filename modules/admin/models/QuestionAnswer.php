<?php

namespace app\modules\admin\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "question_answer".
 *
 * @property integer $id
 * @property string $name
 * @property string $position
 * @property string $comment
 * @property string $avatar_url
 * @property integer $is_published
 * @property string $created_at
 */
class QuestionAnswer extends \yii\db\ActiveRecord
{
    public $avatar;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'question_answer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'position', 'comment', 'avatar_url', 'created_at'], 'required'],
            [['avatar'], 'required', 'on' => ['create']],
            [['comment'], 'string'],
            [['is_published'], 'integer'],
            [['avatar', 'created_at'], 'safe'],
            [['avatar'], 'file', 'extensions'=>'jpg, gif, png'],
            [['name', 'position'], 'string', 'max' => 255],
            [['avatar_url'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin', 'ID'),
            'name' => Yii::t('admin', 'Name Answerer'),
            'position' => Yii::t('admin', 'Position'),
            'comment' => Yii::t('admin', 'Comment Answer'),
            'avatar_url' => Yii::t('admin', 'Avatar Url'),
            'avatar' => Yii::t('admin', 'Avatar Url'),
            'is_published' => Yii::t('admin', 'Is Published'),
            'created_at' => Yii::t('admin', 'Created At'),
        ];
    }

    public function getImageFile()
    {
        $path = Yii::$app->basePath . Yii::$app->params['uploadPathQuestionAnswer'];
        return isset($this->avatar_url) ? $path . $this->avatar_url : null;
    }

    public function getImageUrl()
    {
        $noImage = '/404.png';
        $url = Yii::$app->urlManager->baseUrl . Yii::$app->params['uploadUrlQuestionAnswer'];
        return isset($this->avatar_url) ? $url . $this->avatar_url : $noImage;
    }

    public function uploadImage()
    {
        $image = UploadedFile::getInstance($this, 'avatar');
        if (empty($image)) {
            return false;
        }
        $fileNameArr = explode(".", $image->name);
        $ext = end($fileNameArr);
        $this->avatar_url = Yii::$app->security->generateRandomString().".{$ext}";
        return $image;
    }

    public function deleteImage()
    {
        $file = $this->getImageFile();
        if (empty($file) || !file_exists($file)) {
            return false;
        }
        if (!unlink($file)) {
            return false;
        }
        return true;
    }
}
