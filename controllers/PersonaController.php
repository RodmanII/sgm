<?php

namespace app\controllers;

use Yii;
use app\models\mant\Persona;
use app\models\search\PersonaB;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
* PersonaController implements the CRUD actions for Persona model.
*/
class PersonaController extends Controller
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
  * Lists all Persona models.
  * @return mixed
  */
  public function actionIndex()
  {
    $searchModel = new PersonaB();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
      ]);
    }

    /**
    * Displays a single Persona model.
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
      * Creates a new Persona model.
      * If creation is successful, the browser will be redirected to the 'view' page.
      * @return mixed
      */
      public function actionCreate()
      {
        $model = new Persona();
        /*Aqui tengo que inicializar la propiedad otro_doc del modelo antes de guardarlo,
        para ello uso $_POST[nomda] y numda, probablemente tenga que hacer algo similar en el update y view*/
        $conexion = \Yii::$app->db;
        $transaccion = $conexion->beginTransaction();
        if ($model->load(Yii::$app->request->post())) {
          print_r($_POST);
          exit;
          require_once('../auxiliar/Auxiliar.php');
          if($model->validate()){
            try{
              $model->otro_doc = null;
              if(isset($_POST['nomda']) && isset($_POST['numda'])){
                $model->otro_doc = $_POST['nomda'].':'.$_POST['numda'];
              }
              $model->fecha_nacimiento = fechaMySQL($model->fecha_nacimiento);
              if($model->save()){
                if($_POST['informante']=='Si'){
                  $ulid = $conexion->getLastInsertID();
                  $informanteModel = new Informante();
                  $informanteModel->nombre = $model->nombre.' '.$model->apellido;
                  $informanteModel->genero = $model->genero;
                  $informanteModel->cod_persona = $ulid;
                  if(isset($model->dui)){
                    $informanteModel->tipo_documento = 'Documento Único de Identidad';
                    $informanteModel->numero_documento = $model->dui;
                  }else{
                    $informanteModel->tipo_documento = $_POST['nomda'];
                    $informanteModel->numero_documento = $_POST['numda'];
                  }
                  if(!$informanteModel->save()){
                    throw Exception('No se pudo guardar el registro de informante, intente nuevamente');
                  }
                }
                $transaccion->commit();
                return $this->redirect(['view', 'id' => $model->codigo]);
              }else{
                throw Exception('No se pudo guardar el registro de persona, intente nuevamente');
              }
            }catch(Exception $err){
              $transaccion->rollback();
              Yii::$app->session->setFlash('error', $err->getMessage());
              return $this->redirect(['create']);
            }
          } else {
            return $this->render('create', [
              'model' => $model,
              ]);
            }
          }

          /**
          * Updates an existing Persona model.
          * If update is successful, the browser will be redirected to the 'view' page.
          * @param integer $id
          * @return mixed
          */
          public function actionUpdate($id)
          {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post())) {
              require_once('../auxiliar/Auxiliar.php');
              if($model->validate()){
                try{
                  $informanteModel = Informante::find()->where('cod_persona = :valor',[':valor'=>$model->codigo])->one();
                  if($model->save()){
                    if(isset($informanteModel)){
                      //Si tiene un informante asociada, habra que actualizarlo también
                      $informanteModel->nombre = $model->nombre.' '.$model->apellido;
                      $informanteModel->genero = $model->genero;
                      if(isset($model->dui)){
                        $informanteModel->tipo_documento = 'Documento Único de Identidad';
                        $informanteModel->numero_documento = $model->dui;
                      }else{
                        $informanteModel->tipo_documento = $_POST['nomda'];
                        $informanteModel->numero_documento = $_POST['numda'];
                      }
                      if(!$informanteModel->save()){
                        throw Exception('No se pudo actualizar el registro de informante asociado, intente nuevamente');
                      }
                    }
                    $transaccion->commit();
                  }else{
                    throw Exception('No se pudo actualizar el registro de persona, intente nuevamente');
                  }
                }catch(Exception $err){
                  $transaccion->rollback();
                  Yii::$app->session->setFlash('error', $err->getMessage());
                  return $this->redirect(['create']);
                }
              } else {
                return $this->render('update', [
                  'model' => $model,
                  ]);
                }
              }
            }

            /**
            * Deletes an existing Persona model.
            * If deletion is successful, the browser will be redirected to the 'index' page.
            * @param integer $id
            * @return mixed
            */
            public function actionDelete($id)
            {
              $this->findModel($id)->delete();              
              return $this->redirect(['index']);
            }

            /**
            * Finds the Persona model based on its primary key value.
            * If the model is not found, a 404 HTTP exception will be thrown.
            * @param integer $id
            * @return Persona the loaded model
            * @throws NotFoundHttpException if the model cannot be found
            */
            protected function findModel($id)
            {
              if (($model = Persona::findOne($id)) !== null) {
                return $model;
              } else {
                throw new NotFoundHttpException('The requested page does not exist.');
              }
            }
          }
