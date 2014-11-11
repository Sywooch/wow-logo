<?php

namespace app\modules\admin\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "portfolio".
 *
 * @property string $id
 * @property string $thumbnail_url
 * @property string $title
 * @property string $created_at
 * @property string $images_urls
 *
 * @property Order[] $orders
 */
class Portfolio extends \yii\db\ActiveRecord
{
    public $thumbnail;
    public $images;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'portfolio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thumbnail_url', 'title', 'created_at', 'images_urls'], 'required'],
            [['thumbnail', 'images'], 'required', 'on' => ['create']],
            [['created_at'], 'safe'],
            [['images_urls'], 'string'],
            [['thumbnail', 'images'], 'safe'],
            [['thumbnail'], 'file', 'extensions' => 'jpg, gif, png'],
            [['images'], 'file', 'extensions' => 'jpg, gif, png', 'maxFiles' => 100],
            [['thumbnail_url'], 'string', 'max' => 64],
            [['title'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin', 'ID'),
            'thumbnail_url' => Yii::t('admin', 'Thumbnail Url'),
            'thumbnail' => Yii::t('admin', 'Thumbnail Url'),
            'title' => Yii::t('admin', 'Title'),
            'created_at' => Yii::t('admin', 'Created At'),
            'images_urls' => Yii::t('admin', 'Images Urls'),
            'images' => Yii::t('admin', 'Images Urls'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['id' => 'order_id'])->viaTable('order_has_portfolio', ['portfolio_id' => 'id']);
    }

    public function getImageFile($attribute)
    {
        $path = Yii::$app->basePath . Yii::$app->params['uploadPathPortfolio'];
        if ($attribute == 'thumbnail') {
            return isset($this->thumbnail_url) ? $path . $this->thumbnail_url : null;
        } else {
            $result = [];
            if (isset($this->images_urls)) {
                $images = explode(",", $this->images_urls);
                foreach($images as $image) {
                    $result[] = $path . $image;
                }
            }
            return !empty($result) ? $result : null;
        }
    }

    public function getImageUrl($attribute)
    {
        $noImage = '/404.png';
        $url = Yii::$app->urlManager->baseUrl . Yii::$app->params['uploadUrlPortfolio'];
        if ($attribute == 'thumbnail') {
            return isset($this->thumbnail_url) ? $url . $this->thumbnail_url : $noImage;
        } else {
            $result = [];
            if (isset($this->images_urls)) {
                $images = explode(",", $this->images_urls);
                foreach($images as $image) {
                    $result[] = $url . $image;
                }
            }
            return !empty($result) ? $result : [$noImage];
        }
    }

    public function uploadImage($attribute)
    {
        if ($attribute == 'thumbnail') {
            $image = UploadedFile::getInstance($this, $attribute);
            if (empty($image)) {
                return false;
            }
            $fileNameArr = explode(".", $image->name);
            $ext = end($fileNameArr);
            $this->thumbnail_url = Yii::$app->security->generateRandomString().".{$ext}";
        } else {
            $image = UploadedFile::getInstances($this, $attribute);
            if (empty($image)) {
                return false;
            }
            $result = [];
            foreach($image as $img) {
                $fileNameArr = explode(".", $img->name);
                $ext = end($fileNameArr);
                $result[] = Yii::$app->security->generateRandomString().".{$ext}";
            }
            $this->images_urls = implode(",", $result);
        }
        return $image;
    }

    public function deleteImage($attribute)
    {
        $files = $this->getImageFile($attribute);
        $flag = true;
        if (!is_array($files)) {
            $this->deleteFileHelper($files);
        } else {
            foreach ($files as $file) {
                if (!$this->deleteFileHelper($file)) {
                    $flag = false;
                }
            }
        }
        return $flag;
    }

    public function deleteFileHelper($file)
    {
        if (empty($file) || !file_exists($file)) {
            return false;
        }
        if (!unlink($file)) {
            return false;
        }
        return true;
    }
}