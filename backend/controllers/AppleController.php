<?php

namespace backend\controllers;

use backend\forms\AppleSearch;
use core\entities\Apple\Apple;
use core\forms\manage\Apple\AppleCreateForm;
use yii;
use core\forms\manage\Apple\AppleEditForm;
use core\services\manage\AppleManageService;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Controller;

use yii\helpers\Json;

/**
 * AppleController implements the CRUD actions for Apple model.
 */
class AppleController extends Controller
{
    private $service;

    public function __construct($id, $module, AppleManageService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all Apple models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AppleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Apple model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Apple model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new AppleCreateForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $apple = $this->service->create();
                return $this->redirect(['view', 'id' => $apple->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * Generate a new Apples model.
     * If Generate is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionGenerate()
    {
        try{
            for ($apples_count = 0; $apples_count <=rand(1,100); $apples_count ++) {
                $this->service->create();
            }
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect('index');
    }

    /**
     * Updates an existing Apple model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $apple = $this->findModel($id);

        $form = new AppleEditForm($apple);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($apple->id, $form);
                return $this->redirect(['view', 'id' => $apple->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'apple' => $apple,
        ]);
    }

    public function actionChangeSize(){
        if($_POST['editableKey']){
            $model=Apple::findOne(['id'=>$_POST['editableKey']]);
            try {
                $model->eat($_POST['Apple'][$_POST['editableIndex']]['size']);
                $model->save();
                echo Json::encode(['output'=>number_format($model->size,2,'.', '')]);
            } catch (\Exception $e){
                echo Json::encode(['message'=>$e->getMessage()]);
            }
        }
    }

    /**
     * Fall To Ground Apple.
     * @return mixed
     */
    public function actionFallToGround(int $id){
        $model=Apple::findOne(['id'=>$id]);
        if(!$model) throw new yii\web\HttpException(404,'Apple is not exist');
        $model->status=Apple::STATUS_DROP;
        $model->save();
        return $this->redirect(['index']);
    }
    /**
     * Deletes an existing Apple model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->service->remove($id);
        return $this->redirect(['index']);
    }


    /**

     */
    public function actionDeleteall()
    {
        $this->service->removeAll();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Apple model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Apple the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Apple::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}