<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\Coupon;
use Yii;
use app\modules\admin\models\Order;
use app\modules\admin\models\OrderSearch;
use app\modules\admin\models\OrderHasUser;
use app\modules\admin\models\OrderHasOption;
use app\modules\admin\models\OrderHasPortfolio;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function() {
                                return Yii::$app->user->identity->isAdmin();
                            }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $statusArray = Order::getStatusArray();
        $tariffArray = Order::getTariffArray();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statusArray' => $statusArray,
            'tariffArray' => $tariffArray
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'update' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();
        if ($model->load(Yii::$app->request->post())) {
            $files = $model->uploadImage('files');
            $images = $model->uploadImage('images');
            $model->files = $files;
            $model->images = $images;
            if ($model->coupon && !$model->price) {
                $summ = $model->coupon->price_drop;
                $model->calcPrice($_POST['Order']['options']);
                $model->price = $model->price > $summ ? $model->price - $summ : 0;
            }
            if (!$model->price_no_disc || !$model->price) {
                if ($model->price) {
                    $model->price_no_disc = $model->price;
                } else {
                    $model->calcPrice($_POST['Order']['options']);
                }
            }
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
                return $this->redirect(['update', 'id' => $model->id]);
            }
            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'update' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldFiles = $model->getImageFile('files');
        $oldImages = $model->getImageFile('images');
        if ($model->load(Yii::$app->request->post())) {
            $files = $model->uploadImage('files');
            $images = $model->uploadImage('images');
            if ($model->coupon && !$model->price) {
                $summ = $model->coupon->price_drop;
                $model->calcPrice($_POST['Order']['options']);
                $model->price = $model->price > $summ ? $model->price - $summ : 0;
            }
            if (!$model->price_no_disc || !$model->price) {
                if ($model->price) {
                    $model->price_no_disc = $model->price;
                } else {
                    $model->calcPrice($_POST['Order']['options']);
                }
            }
            if ($model->save()) {
                if ($files !== false) {
                    foreach ($oldFiles as $oldFile) {
                        if (file_exists($oldFile)) {
                            unlink($oldFile);
                        }
                    }
                    $path = $model->getImageFile('files');
                    foreach($files as $key => $file) {
                        $file->saveAs($path[$key]);
                    }
                }
                if ($images !== false) {
                    foreach ($oldImages as $oldImage) {
                        if (file_exists($oldImage)) {
                            unlink($oldImage);
                        }
                    }
                    $path = $model->getImageFile('images');
                    foreach($images as $key => $image) {
                        $image->saveAs($path[$key]);
                    }
                }
                $model->saveMultiRelations();
            }
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->delete()) {
            if (!$model->deleteImage('files') || !$model->deleteImage('images')) {
                Yii::$app->session->setFlash('error', 'Error deleting attachments');
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
