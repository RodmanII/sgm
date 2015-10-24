<?php

namespace app\controllers;

use Yii;
use app\models\mant\Informante;
use app\models\search\InformanteB;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\base\UserException;

/**
* InformanteController implements the CRUD actions for Informante model.
*/
class InformanteController extends Controller
{
  public function behaviors()
  {
    return [
      'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
          'delete' => ['post'],
        ],
      ],
    ];
  }

  /**
  * Lists all Informante models.
  * @return mixed
  */
  public function actionIndex()
  {
    $searchModel = new InformanteB();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
      ]);
    }

    /**
    * Displays a single Informante model.
    * @param integer $id
    * @return mixed
    */
    public function actionView($id)
    {
      return $this->render('view', [
        'model' => $this->findModel($id),
        ]);
      }

      /**
      * Creates a new Informante model.
      * If creation is successful, the browser will be redirected to the 'view' page.
      * @return mixed
      */
      public function actionCreate()
      {
        $model = new Informante();
        $conexion = \Yii::$app->db;
        $model->scenario = 'create';
        $transaccion = $conexion->beginTransaction();
        if ($model->load(Yii::$app->request->post())) {
          $firma = UploadedFile::getInstance($model, 'firma');
          try{
            // store the source file name
            if(empty($firma)){
              throw new UserException('No se ha especificado el archivo, intente de nuevo');
            }
            $ext = end((explode(".", $firma->name)));

            // generate a unique file name
            $nombrec = Yii::$app->security->generateRandomString().'.'.$ext;

            // the path to save file, you can set an uploadPath
            // in Yii::$app->params (as used in example below)
            $path = Yii::$app->basePath.'/firmas/'.strtolower($model->genero).'/'.$nombrec;
            while (file_exists($path)) {
              $nombrec = Yii::$app->security->generateRandomString().'.'.$ext;
              $path = Yii::$app->basePath.'/firmas/'.strtolower($model->genero).'/'.$nombrec;
            }
            $model->firma = $nombrec;
            if($model->save()){
              if($firma->saveAs($path)){
                chmod($path, 0644);
                $transaccion->commit();
                return $this->redirect(['view', 'id' => $model->codigo]);
              }else{
                throw new UserException('No se pudo guardar el archivo de imagen, intente de nuevo');
              }
            }else{
              throw new UserException('No se pudo guardar el registro, intente de nuevo');
            }
          }catch(UserException $err){
            $transaccion->rollback();
            Yii::$app->session->setFlash('error', $err->getMessage());
            return $this->render('create', ['model' => $model,]);
          }
        }
        return $this->render('create', ['model' => $model,]);
      }

      /**
      * Updates an existing Informante model.
      * If update is successful, the browser will be redirected to the 'view' page.
      * @param integer $id
      * @return mixed
      */
      public function actionUpdate($id)
      {
        $model = $this->findModel($id);
        $conexion = \Yii::$app->db;
        $transaccion = $conexion->beginTransaction();
        $firmar = $model->firma;
        $pathv = Yii::$app->basePath.'/firmas/'.strtolower($model->genero).'/'.$firmar;
        if ($model->load(Yii::$app->request->post())) {
          $firma = UploadedFile::getInstance($model, 'firma');
          try{
            $garchivo = true;
            // store the source file name
            if(!empty($firma)){
              $ext = end((explode(".", $firma->name)));

              // generate a unique file name
              $nombrec = Yii::$app->security->generateRandomString().'.'.$ext;

              // the path to save file, you can set an uploadPath
              // in Yii::$app->params (as used in example below)
              $path = Yii::$app->basePath.'/firmas/'.strtolower($model->genero).'/'.$nombrec;
              while (file_exists($path)) {
                $nombrec = Yii::$app->security->generateRandomString().'.'.$ext;
                $path = Yii::$app->basePath.'/firmas/'.strtolower($model->genero).'/'.$nombrec;
              }
              $model->firma = $nombrec;
            }else{
              $garchivo = false;
              $model->firma = $firmar;
            }
            if($model->save()){
              if($garchivo){
                if($firma->saveAs($path)){
                  chmod($path, 0644);
                  unlink($pathv);
                }else{
                  throw new UserException('No se pudo guardar el archivo de imagen, intente de nuevo');
                }
              }
              $transaccion->commit();
              return $this->redirect(['view', 'id' => $model->codigo]);
            }else{
              throw new UserException('No se pudo guardar el registro, intente de nuevo');
            }
          }catch(UserException $err){
            $transaccion->rollback();
            Yii::$app->session->setFlash('error', $err->getMessage());
            return $this->render('create', ['model' => $model,]);
          }
        }
        return $this->render('update', ['model' => $model,]);
      }

      /**
      * Deletes an existing Informante model.
      * If deletion is successful, the browser will be redirected to the 'index' page.
      * @param integer $id
      * @return mixed
      */
      public function actionDelete($id)
      {
        $model = $this->findModel($id);
        $pathv = Yii::$app->basePath.'/firmas/'.strtolower($model->genero).'/'.$model->firma;
        unlink($pathv);
        $model->delete();
        return $this->redirect(['index']);
      }

      /**
      * Finds the Informante model based on its primary key value.
      * If the model is not found, a 404 HTTP exception will be thrown.
      * @param integer $id
      * @return Informante the loaded model
      * @throws NotFoundHttpException if the model cannot be found
      */
      protected function findModel($id)
      {
        if (($model = Informante::findOne($id)) !== null) {
          return $model;
        } else {
          throw new NotFoundHttpException('The requested page does not exist.');
        }
      }
    }
