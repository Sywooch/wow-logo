<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\QuestionAnswer;
use app\modules\admin\models\QuestionAnswerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * QuestionAnswerController implements the CRUD actions for QuestionAnswer model.
 */
class QuestionAnswerController extends Controller
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

    public function actions()
    {
        return [
            'comment-upload' => [
                'class' => 'vova07\imperavi\actions\UploadAction',
                'url' => '/uploads/question-answer/',
                'path' => '@webroot/uploads/question-answer'
            ],
        ];
    }

    /**
     * Lists all QuestionAnswer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new QuestionAnswerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new QuestionAnswer model.
     * If creation is successful, the browser will be redirected to the 'update' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new QuestionAnswer();
        $model->scenario = 'create';
        if ($model->load(Yii::$app->request->post())) {
            $avatar = $model->uploadImage('avatar');
            $model->avatar = $avatar;
            $model->created_at = date("Y-m-d H:i:s");
            if ($model->save()) {
                if ($avatar !== false) {
                    $path = $model->getImageFile();
                    $avatar->saveAs($path);
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
     * Updates an existing QuestionAnswer model.
     * If update is successful, the browser will be redirected to the 'update' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldAvatar = $model->getImageFile();
        if ($model->load(Yii::$app->request->post())) {
            $avatar = $model->uploadImage();
            if ($model->save()) {
                if ($avatar !== false && (!file_exists($oldAvatar) || unlink($oldAvatar))) {
                    $path = $model->getImageFile();
                    $avatar->saveAs($path);
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
     * Deletes an existing QuestionAnswer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->delete()) {
            if (!$model->deleteImage()) {
                Yii::$app->session->setFlash('error', 'Error deleting images');
            }
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the QuestionAnswer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return QuestionAnswer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = QuestionAnswer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}