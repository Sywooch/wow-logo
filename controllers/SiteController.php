<?php

namespace app\controllers;

use app\modules\admin\models\ClientReview;
use app\modules\admin\models\Coupon;
use app\modules\admin\models\Option;
use app\modules\admin\models\Portfolio;
use app\modules\admin\models\QuestionAnswer;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use app\models\ContactForm;
use app\modules\admin\models\Order;
use yii\web\View;
use yii\helpers\Url;

class SiteController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'result' => ['post'],
                    'success' => ['post'],
                    'fail' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            //robokassa
            'result' => [
                'class' => '\robokassa\ResultAction',
                'callback' => [$this, 'resultCallback'],
            ],
            'success' => [
                'class' => '\robokassa\SuccessAction',
                'callback' => [$this, 'successCallback'],
            ],
            'fail' => [
                'class' => '\robokassa\FailAction',
                'callback' => [$this, 'failCallback'],
            ],
        ];
    }

	public function beforeAction($action)
	{

		$tariff1Price = Yii::$app->params['tariff1Price'];
		$tariff1PriceWas = Yii::$app->params['tariff1PriceNoDisc'];
		$tariff2Price = Yii::$app->params['tariff2Price'];
		$tariff2PriceWas = Yii::$app->params['tariff2PriceNoDisc'];
		$tariff3Price = Yii::$app->params['tariff3Price'];
		$tariff3PriceWas = Yii::$app->params['tariff3PriceNoDisc'];
		$couponCheck = Url::toRoute('/site/check-coupon');

		/*TODO get vars*/
		$discount = 0;
		$discountCode = '\'\'';

		$rightButtonText = Yii::t('app', 'заказать');
		$rightButtonSelectedText = Yii::t('app', 'выбрано');

		$js = <<<JS
window.initData = {
	tariff1Price : $tariff1Price,
	tariff1PriceWas : $tariff1PriceWas,
	tariff2Price : $tariff2Price,
	tariff2PriceWas : $tariff2PriceWas,
	tariff3Price : $tariff3Price,
	tariff3PriceWas : $tariff3PriceWas,
	discount: $discount,
	discountCode: $discountCode,
	portfolioItemsIncluded: [],
	couponCheck: '$couponCheck',
	rightButtonText: '$rightButtonText',
	rightButtonSelectedText: '$rightButtonSelectedText'
};
JS;

		$this->getView()->registerJs($js, View::POS_END);
		return parent::beforeAction($action);
	}

    public function actionIndex()
    {
        $contactForm = new ContactForm();
        $clientReviews = ClientReview::find()->where(['is_published' => true])->orderBy('created_at desc')->limit(5)->all();
        $questionAnswers = QuestionAnswer::find()->where(['is_published' => true])->orderBy('created_at desc')->limit(5)->all();
        $portfolios = Portfolio::find()->orderBy('created_at')->limit(6)->all();
        $portfolioImages = $this->getPortfolioGalleries($portfolios);
        $ordersDone = Order::find()->where(['status' => Order::STATUS_CLOSED])->count();
        $ordersWIP = Order::find()
            ->where('status > :1 AND status < :2', [
                ':1' => Order::STATUS_NOT_PAYED,
                ':2' => Order::STATUS_CLOSED
            ])->count();
        $options = Option::find()->where(['is_published' => true])->all();
        return $this->render('index', [
            'contactForm' => $contactForm,
            'clientReviews' => $clientReviews,
            'questionAnswers' => $questionAnswers,
            'portfolios' => $portfolios,
            'portfolioImages' => json_encode($portfolioImages),
            'options' => $options,
            'ordersDone' => $ordersDone,
            'ordersWIP' => $ordersWIP,
        ]);
    }

    public function actionPortfolio()
    {
        $portfolios = Portfolio::find()->orderBy('created_at')->all();
        $portfolioImages = $this->getPortfolioGalleries($portfolios);
        return $this->render('portfolio', [
            'portfolios' => $portfolios,
            'portfolioImages' => json_encode($portfolioImages),
        ]);
    }

    public function getPortfolioGalleries($portfolios)
    {
        $result = [];
        foreach ($portfolios as $portfolio) {
            $portImages = $portfolio->getImageUrl('images');
            foreach ($portImages as $image) {
                $result[$portfolio->id][] = ['href' => $image];
            }
        }
        return $result;
    }

    public function actionOrder()
    {
        $model = new Order();
        if ($model->load(Yii::$app->request->post())) {
            $this->getJsonAttributes($model, json_decode($_POST['jsonData'], true));
            $files = $model->uploadImage('files');
            $images = $model->uploadImage('images');
            $model->files = $files;
            $model->images = $images;
            if ($model->save()) {
                if ($files !== false) {
                    $path = $model->getImageFile('files');
                    foreach($files as $key => $file) {
                        $file->saveAs($path[$key]);
                    }
                }
                if ($images !== false) {
                    $path = $model->getImageFile('images');
                    foreach($images as $key => $image) {
                        $image->saveAs($path[$key]);
                    }
                }
                $model->saveMultiRelations();
                if ($model->price > 0) {
                    $merchant = Yii::$app->get('robokassa');
                    return $merchant->payment($model->price, $model->id, Yii::t('app', 'Заказ на CreativeLogo'), null, $model->client_email);
                } else {
                    $model->paymentDone();
                    return $this->render('robokassa', [
                        'success' => true
                    ]);
                }
            }
            return $this->redirect('/');
        } else {
            $options = Option::find()->where(['is_published' => true])->all();
            return $this->render('order', [
                'options' => $options,
				'order' => $model
            ]);
        }
    }

    public function getJsonAttributes($model, $jsonData)
    {
        /** @var Order $model */
        $model->tariff = isset($jsonData['tariff']) ? (integer)$jsonData['tariff'] : Order::TARIFF_START;
        if ($model->tariff == Order::TARIFF_START) {
            $model->logo_variants = isset($jsonData['logoVarQty']) ? (integer)$jsonData['logoVarQty'] : 1;
            if (isset($jsonData['optCheckedCollection'])) {
                $options = json_decode($jsonData['optCheckedCollection'], true);
                foreach($options as $optionId => $price) {
                    $_POST['Order']['options'][] = mb_substr($optionId, 7);
                }
            }
        }
        $model->hilarity = isset($jsonData['styles']['hilarity']) ? $jsonData['styles']['hilarity'] : 50;
        $model->modernity = isset($jsonData['styles']['modernity']) ? $jsonData['styles']['modernity'] : 50;
        $model->minimalism = isset($jsonData['styles']['minimalism']) ? $jsonData['styles']['minimalism'] : 50;
        if (isset($jsonData['checkedPortfolioItems'])) {
            $portfolios = json_decode($jsonData['checkedPortfolioItems'], true);
            foreach($portfolios as $portfolioId => $thumbnail) {
                $_POST['Order']['portfolios'][] = $portfolioId;
            }
        }
        if (isset($jsonData['checkedColors'])) {
            $colors = json_decode($jsonData['checkedColors'], true);
            $model->color_scheme = implode(',', $colors);
        }
        $options = isset($_POST['Order']['options']) ? $_POST['Order']['options'] : [];
        $model->calcPrice($options);
        if (isset($jsonData['coupon'])) {
            $couponJson = json_decode($jsonData['coupon'], true);
            $coupon = Coupon::checkCouponByCode($couponJson['code']);
            if ($coupon) {
                $model->coupon_id = $coupon->id;
                $model->price -= $coupon->price_drop;
            }
        }
    }

    public function actionContact()
    {
        $model = new ContactForm();
        Yii::$app->response->format = 'json';
        if (Yii::$app->request->isAjax) {
            if (isset($_POST['ContactForm'])) {
                $model->attributes = $_POST['ContactForm'];
                if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
                    return ['status' => 'success'];
                }
            }
            return ['status' => 'fail'];
        } else {
            return $this->redirect('/');
        }
    }

    public function actionCheckCoupon()
    {
        Yii::$app->response->format = 'json';
        if (Yii::$app->request->isAjax) {
            if (isset($_POST['CouponCode'])) {
                $coupon = Coupon::checkCouponByCode($_POST['CouponCode']);
                if ($coupon) {
                    return ['status' => 'success', 'summ' => $coupon->price_drop];
                }
            }
            return ['status' => 'fail'];
        } else {
            return $this->redirect('/');
        }
    }

	/**
	 * Callback.
	 * @param \robokassa\Merchant $merchant merchant.
	 * @param integer $nInvId invoice ID.
	 * @param float $nOutSum sum.
	 * @param array $shp user attributes.
	 * @return string
	 */
    public function successCallback($merchant, $nInvId, $nOutSum, $shp)
    {
        return $this->render('robokassa', [
            'success' => true
        ]);
    }

    public function resultCallback($merchant, $nInvId, $nOutSum, $shp)
    {
        $model = $this->loadModel($nInvId);
        $model->paymentDone();
    }

    public function failCallback($merchant, $nInvId, $nOutSum, $shp)
    {
        $model = $this->loadModel($nInvId);
        if ($model->status == Order::STATUS_NEW) {
            $model->updateAttributes(['status' => Order::STATUS_NOT_PAYED]);
            return $this->render('robokassa', [
                'success' => false
            ]);
        } else {
            return $this->redirect('/');
        }
    }

    /**
     * @param integer $id
     * @return Order
     * @throws \yii\web\BadRequestHttpException
     */
    protected function loadModel($id)
    {
        $model = Order::findOne($id);
        if ($model === null) {
            throw new BadRequestHttpException;
        }
        return $model;
    }
}