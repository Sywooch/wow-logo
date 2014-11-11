<?php

namespace app\modules\admin\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "order".
 *
 * @property string $id
 * @property integer $status
 * @property integer $composition
 * @property string $client_email
 * @property string $skype
 * @property string $telephone
 * @property string $company_name
 * @property string $site_link
 * @property string $description
 * @property integer $tariff
 * @property integer $logo_variants
 * @property integer $hilarity
 * @property integer $modernity
 * @property integer $minimalism
 * @property string $money_earning
 * @property string $who_clients
 * @property string $company_strength
 * @property string $who_competitors
 * @property string $created_at
 * @property double $price_no_disc
 * @property double $price
 * @property string $coupon_id
 * @property string $images_urls
 * @property string $files_urls
 * @property string $color_scheme
 *
 * @property Coupon $coupon
 * @property Option[] $options
 * @property Portfolio[] $portfolios
 * @property User[] $users
 * @property OrderHasOption[] $orderHasOptions
 * @property OrderHasPortfolio[] $orderHasPortfolios
 * @property OrderHasUser[] $orderHasUsers
 */
class Order extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_NOT_PAYED = 1;
    const STATUS_IN_WORK = 2;
    const STATUS_EDIT_STAGE = 3;
    const STATUS_EDITS_NEEDED = 4;
    const STATUS_BLUEPRINTS_NEEDED = 5;
    const STATUS_CLIENT_CHECK = 6;
    const STATUS_CLOSED = 7;

    const COMPOSITION_LOGO_TEXT = 1;
    const COMPOSITION_TEXT = 2;
    const COMPOSITION_LOGO = 3;
    const COMPOSITION_DESIGNER = 4;

    const TARIFF_START = 1;
    const TARIFF_BUSINESS = 2;
    const TARIFF_SCROOGE = 3;

    public $files;
    public $images;

    public function init()
    {
        $this->hilarity = 50;
        $this->modernity = 50;
        $this->minimalism = 50;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_email'], 'required'],
            [['description', 'money_earning', 'who_clients', 'company_strength', 'who_competitors', 'images_urls', 'files_urls', 'color_scheme'], 'string'],
            [['tariff', 'logo_variants', 'status', 'composition', 'coupon_id'], 'integer'],
            [['hilarity', 'modernity', 'minimalism'], 'integer', 'min' => 0, 'max' => 100],
            [['created_at', 'images', 'files'], 'safe'],
            [['images'], 'file', 'extensions' => 'jpg, gif, png', 'maxFiles' => 10, 'maxSize' => 1048576],
            [['files'], 'file', 'maxFiles' => 10, 'maxSize' => 1048576],
            [['price_no_disc', 'price'], 'number'],
            [['client_email', 'skype', 'telephone'], 'string', 'max' => 128],
            [['client_email'], 'email'],
            [['company_name', 'site_link'], 'string', 'max' => 255],
            ['status', 'default', 'value' => self::STATUS_NEW],
            ['status', 'in', 'range' => array_keys(self::getStatusArray())],

            ['composition', 'default', 'value' => self::COMPOSITION_DESIGNER],
            ['composition', 'in', 'range' => array_keys(self::getCompositionArray())],

            ['tariff', 'default', 'value' => self::TARIFF_START],
            ['tariff', 'in', 'range' => array_keys(self::getTariffArray())],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin', 'ID'),
            'client_email' => Yii::t('admin', 'Client Email'),
            'skype' => Yii::t('admin', 'Client Skype'),
            'telephone' => Yii::t('admin', 'Client Telephone'),
            'company_name' => Yii::t('admin', 'Company Name'),
            'site_link' => Yii::t('admin', 'Site Link'),
            'description' => Yii::t('admin', 'Description'),
            'tariff' => Yii::t('admin', 'Tariff ID'),
            'logo_variants' => Yii::t('admin', 'Logo Variants'),
            'hilarity' => Yii::t('admin', 'Hilarity'),
            'modernity' => Yii::t('admin', 'Modernity'),
            'minimalism' => Yii::t('admin', 'Minimalism'),
            'money_earning' => Yii::t('admin', 'Money Earning'),
            'who_clients' => Yii::t('admin', 'Who Clients'),
            'company_strength' => Yii::t('admin', 'Company Strength'),
            'who_competitors' => Yii::t('admin', 'Who Competitors'),
            'created_at' => Yii::t('admin', 'Created At'),
            'price_no_disc' => Yii::t('admin', 'Price No Disc'),
            'price' => Yii::t('admin', 'Price'),
            'status' => Yii::t('admin', 'Status'),
            'composition' => Yii::t('admin', 'Composition'),
            'coupon_id' => Yii::t('admin', 'Coupon ID'),
            'images_urls' => Yii::t('admin', 'Images Urls'),
            'images' => Yii::t('admin', 'Images Urls'),
            'files_urls' => Yii::t('admin', 'Files Urls'),
            'files' => Yii::t('admin', 'Files Urls'),
            'color_scheme' => Yii::t('admin', 'Color Scheme'),
            'users' => Yii::t('admin', 'Designers'),
            'options' => Yii::t('admin', 'Options'),
            'portfolios' => Yii::t('admin', 'Portfolios'),
        ];
    }

    /**
     * @return array Status array.
     */
    public static function getStatusArray()
    {
        return [
            self::STATUS_NEW => Yii::t('admin', 'STATUS_NEW'),
            self::STATUS_NOT_PAYED => Yii::t('admin', 'STATUS_NOT_PAYED'),
            self::STATUS_IN_WORK => Yii::t('admin', 'STATUS_IN_WORK'),
            self::STATUS_EDIT_STAGE => Yii::t('admin', 'STATUS_EDIT_STAGE'),
            self::STATUS_EDITS_NEEDED => Yii::t('admin', 'STATUS_EDITS_NEEDED'),
            self::STATUS_BLUEPRINTS_NEEDED => Yii::t('admin', 'STATUS_BLUEPRINTS_NEEDED'),
            self::STATUS_CLIENT_CHECK => Yii::t('admin', 'STATUS_CLIENT_CHECK'),
            self::STATUS_CLOSED => Yii::t('admin', 'STATUS_CLOSED'),
        ];
    }

    /**
     * @return array Composition array.
     */
    public static function getCompositionArray()
    {
        return [
            self::COMPOSITION_LOGO_TEXT => Yii::t('admin', 'COMPOSITION_LOGO_TEXT'),
            self::COMPOSITION_TEXT => Yii::t('admin', 'COMPOSITION_TEXT'),
            self::COMPOSITION_LOGO => Yii::t('admin', 'COMPOSITION_LOGO'),
            self::COMPOSITION_DESIGNER => Yii::t('admin', 'COMPOSITION_DESIGNER'),
        ];
    }

    /**
     * @return array Tariff array.
     */
    public static function getTariffArray()
    {
        return [
            self::TARIFF_START => Yii::t('admin', 'TARIFF_START'),
            self::TARIFF_BUSINESS => Yii::t('admin', 'TARIFF_BUSINESS'),
            self::TARIFF_SCROOGE => Yii::t('admin', 'TARIFF_SCROOGE'),
        ];
    }

    /**
     * @return string status.
     */
    public function getStatus()
    {
        $statuses = self::getStatusArray();
        return $statuses[$this->status];
    }

    /**
     * @return string composition.
     */
    public function getComposition()
    {
        $compositions = self::getCompositionArray();
        return $compositions[$this->composition];
    }

    /**
     * @return string tariff.
     */
    public function getTariff()
    {
        $tariff = self::getTariffArray();
        return $tariff[$this->tariff];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoupon()
    {
        return $this->hasOne(Coupon::className(), ['id' => 'coupon_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOptions()
    {
        return $this->hasMany(Option::className(), ['id' => 'option_id'])->viaTable('order_has_option', ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderHasOptions()
    {
        return $this->hasMany(OrderHasOption::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortfolios()
    {
        return $this->hasMany(Portfolio::className(), ['id' => 'portfolio_id'])->viaTable('order_has_portfolio', ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderHasPortfolios()
    {
        return $this->hasMany(OrderHasPortfolio::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('order_has_user', ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderHasUsers()
    {
        return $this->hasMany(OrderHasUser::className(), ['order_id' => 'id']);
    }

    public function saveMultiRelations()
    {
        foreach ($this->orderHasUsers as $orderHasUser) {
            $orderHasUser->delete();
        }
        foreach ($this->orderHasOptions as $orderHasOption) {
            $orderHasOption->delete();
        }
        foreach ($this->orderHasPortfolios as $orderHasPortfolio) {
            $orderHasPortfolio->delete();
        }
        if (isset($_POST['Order']['users']) && $_POST['Order']['users']) {
            foreach ($_POST['Order']['users'] as $userId) {
                $orderHasUser = new OrderHasUser;
                $orderHasUser->order_id = $this->id;
                $orderHasUser->user_id = $userId;
                $orderHasUser->save();
            }
        }
        if (isset($_POST['Order']['options']) && $_POST['Order']['options']) {
            foreach ($_POST['Order']['options'] as $optionId) {
                $orderHasOption = new OrderHasOption;
                $orderHasOption->order_id = $this->id;
                $orderHasOption->option_id = $optionId;
                $orderHasOption->save();
            }
        }
        if (isset($_POST['Order']['portfolios']) && $_POST['Order']['portfolios']) {
            foreach ($_POST['Order']['portfolios'] as $portfolioId) {
                $orderHasPortfolio = new OrderHasPortfolio;
                $orderHasPortfolio->order_id = $this->id;
                $orderHasPortfolio->portfolio_id = $portfolioId;
                $orderHasPortfolio->save();
            }
        }
    }

    public function getImageFile($attribute)
    {
        $path = Yii::$app->basePath . Yii::$app->params['uploadPathOrder'];
        $result = [];
        if ($attribute == 'files') {
            if (isset($this->files_urls)) {
                $files = explode(",", $this->files_urls);
                foreach($files as $file) {
                    $result[] = $path . $file;
                }
            }
        } else {
            if (isset($this->images_urls)) {
                $images = explode(",", $this->images_urls);
                foreach($images as $image) {
                    $result[] = $path . $image;
                }
            }
        }
        return !empty($result) ? $result : null;
    }

    public function getImageUrl($attribute)
    {
        $noImage = '/404.png';
        $url = Yii::$app->urlManager->baseUrl . Yii::$app->params['uploadUrlOrder'];
        $result = [];
        if ($attribute == 'files') {
            if (isset($this->files_urls)) {
                $files = explode(",", $this->files_urls);
                foreach($files as $file) {
                    $result[] = $url . $file;
                }
            }
        } else {
            if (isset($this->images_urls)) {
                $images = explode(",", $this->images_urls);
                foreach($images as $image) {
                    $result[] = $url . $image;
                }
            }
        }
        return !empty($result) ? $result : [$noImage];
    }

    public function uploadImage($attribute)
    {
        $images = UploadedFile::getInstances($this, $attribute);
        if (empty($images)) {
            return false;
        }
        $result = [];
        foreach($images as $image) {
            $fileNameArr = explode(".", $image->name);
            $ext = end($fileNameArr);
            $result[] = Yii::$app->security->generateRandomString().".{$ext}";
        }
        if ($attribute == 'files') {
            $this->files_urls = implode(",", $result);
        } else {
            $this->images_urls = implode(",", $result);
        }
        return $images;
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

    public function calcPrice($options = [])
    {
        $this->logo_variants ?: $this->logo_variants = 1;
        $this->tariff ?: $this->tariff = self::TARIFF_START;
        if ($this->tariff == Order::TARIFF_SCROOGE) {
            $this->price = Yii::$app->params['tariff3Price'];
            $this->price_no_disc = Yii::$app->params['tariff3PriceNoDisc'];
            $this->logo_variants = Yii::$app->params['tariff3LogoVariants'];
        } elseif ($this->tariff == Order::TARIFF_BUSINESS) {
            $this->price = Yii::$app->params['tariff2Price'];
            $this->price_no_disc = Yii::$app->params['tariff2PriceNoDisc'];
            $this->logo_variants = Yii::$app->params['tariff2LogoVariants'];
        } else {
            $totalOptionsSum = 0;
            if ($options) {
                foreach ($options as $option) {
                    $totalOptionsSum += Option::findOne($option)->price;
                }
            }
            $this->price = $this->logo_variants * Yii::$app->params['tariff1Price'] + $totalOptionsSum;
            $this->price_no_disc = $this->logo_variants * Yii::$app->params['tariff1PriceNoDisc'] + $totalOptionsSum;
        }
    }

    public function paymentDone()
    {
        $this->updateAttributes(['status' => Order::STATUS_IN_WORK]);
        Yii::$app->mailer->compose()
            ->setTo($this->client_email)
            ->setFrom(Yii::$app->params['siteEmail'])
            ->setSubject(Yii::t('app', 'Заказ на CreativeLogo'))
            ->setTextBody(Yii::t('app', 'Спасибо, оплата прошла успешно, мы свяжемся с Вами в ближайшее время.'))
            ->send();
        Yii::$app->mailer->compose()
            ->setTo(Yii::$app->params['adminEmail'])
            ->setFrom(Yii::$app->params['siteEmail'])
            ->setSubject(Yii::t('app', 'Заказ на CreativeLogo'))
            ->setTextBody(Yii::t('app', 'Поступил новый заказ на CreativeLogo'))
            ->send();
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                if (!$this->created_at) {
                    $this->created_at = date("Y-m-d H:i:s");
                }
                if (!$this->status) {
                    $this->status = self::STATUS_NEW;
                }
                if (!$this->composition) {
                    $this->composition = self::COMPOSITION_DESIGNER;
                }
                if (!$this->tariff) {
                    $this->tariff = self::TARIFF_START;
                }
            }
            return true;
        }
        return false;
    }
}