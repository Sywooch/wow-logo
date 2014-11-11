<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Portfolio;
use app\modules\admin\models\PortfolioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PortfolioController implements the CRUD actions for Portfolio model.
 */
class PortfolioController extends Controller
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
     * Lists all Portfolio models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PortfolioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Portfolio model.
     * If creation is successful, the browser will be redirected to the 'update' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Portfolio();
        $model->scenario = 'create';
        if ($model->load(Yii::$app->request->post())) {
            $thumbnail = $model->uploadImage('thumbnail');
            $images = $model->uploadImage('images');
            $model->thumbnail = $thumbnail;
            $model->images = $images;
            $model->created_at = date("Y-m-d H:i");
            if ($model->save()) {
                if ($thumbnail !== false) {
                    $path = $model->getImageFile('thumbnail');
                    $thumbnail->saveAs($path);
                }
                if ($images !== false) {
                    $path = $model->getImageFile('images');
                    foreach($images as $key => $image) {
                        $image->saveAs($path[$key]);
                    }
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
     * Updates an existing Portfolio model.
     * If update is successful, the browser will be redirected to the 'update' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldThumbnail = $model->getImageFile('thumbnail');
        $oldImages = $model->getImageFile('images');
        if ($model->load(Yii::$app->request->post())) {
            $thumbnail = $model->uploadImage('thumbnail');
            $images = $model->uploadImage('images');
            if ($model->save()) {
                if ($thumbnail !== false && (!file_exists($oldThumbnail) || unlink($oldThumbnail))) {
                    $path = $model->getImageFile('thumbnail');
                    $thumbnail->saveAs($path);
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
            }
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Portfolio model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->delete()) {
            if (!$model->deleteImage('thumbnail') || !$model->deleteImage('images')) {
                Yii::$app->session->setFlash('error', 'Error deleting images');
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Portfolio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Portfolio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Portfolio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
