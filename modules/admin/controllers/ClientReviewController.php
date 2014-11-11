<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\ClientReview;
use app\modules\admin\models\ClientReviewSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClientReviewController implements the CRUD actions for ClientReview model.
 */
class ClientReviewController extends Controller
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
     * Lists all ClientReview models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClientReviewSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new ClientReview model.
     * If creation is successful, the browser will be redirected to the 'update' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ClientReview();
        $model->scenario = 'create';
        if ($model->load(Yii::$app->request->post())) {
            $logo = $model->uploadImage('logo');
            $clientImage = $model->uploadImage('clientImage');
            $model->logo = $logo;
            $model->clientImage = $clientImage;
            $model->created_at = date("Y-m-d H:i:s");
            if ($model->save()) {
                if ($logo !== false) {
                    $path = $model->getImageFile('logo');
                    $logo->saveAs($path);
                }
                if ($clientImage !== false) {
                    $path = $model->getImageFile('clientImage');
                    $clientImage->saveAs($path);
                }
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
     * Updates an existing ClientReview model.
     * If update is successful, the browser will be redirected to the 'update' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldLogo = $model->getImageFile('logo');
        $oldClientImage = $model->getImageFile('clientImage');
        if ($model->load(Yii::$app->request->post())) {
            $logo = $model->uploadImage('logo');
            $clientImage = $model->uploadImage('clientImage');
            if ($model->save()) {
                if ($logo !== false && (!file_exists($oldLogo) || unlink($oldLogo))) {
                    $path = $model->getImageFile('logo');
                    $logo->saveAs($path);
                }
                if ($clientImage !== false && (!file_exists($oldClientImage) || unlink($oldClientImage))) {
                    $path = $model->getImageFile('clientImage');
                    $clientImage->saveAs($path);
                }
            }
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ClientReview model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->delete()) {
            if (!$model->deleteImage('logo') || !$model->deleteImage('clientImage')) {
                Yii::$app->session->setFlash('error', 'Error deleting images');
            }
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the ClientReview model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ClientReview the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ClientReview::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}