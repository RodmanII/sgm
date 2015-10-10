<?php

namespace app\controllers;

use Yii;
use app\models\mant\Persona;
use app\models\mant\Informante;
use app\models\search\PersonaB;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\UserException;

/**
* PersonaController implements the CRUD actions for Persona model.
* AVISO IMPORTANTE: Debido a que no estoy usando los botones de submit de ActiveForm sino que simples botones y
* enviando el formulario por medio de JS los valores que se tendrian que guardar como nulos se pasan como candenas vacias
* esto debido a que las solicitudes POST y GET no admiten null.
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
        $conexion = \Yii::$app->db;
        $transaccion = $conexion->beginTransaction();
        if ($model->load(Yii::$app->request->post())) {
          require_once('../auxiliar/Auxiliar.php');
          if($model->validate()){
            foreach ($model->attributes as $llave => $elemento) {
              if($model[$llave] == ''){
                $model[$llave] = null;
              }
            }
            try{
              $model->otro_doc = null;
              $model->estado = 'Activo';
              if($_POST['nomda'] != '' && $_POST['numda'] != ''){
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
                  if(!empty($model->dui)){
                    $informanteModel->tipo_documento = 'Documento Único de Identidad';
                    $informanteModel->numero_documento = $model->dui;
                  }else{
                    $informanteModel->tipo_documento = $_POST['nomda'];
                    $informanteModel->numero_documento = $_POST['numda'];
                  }
                  if(!$informanteModel->save()){
                    throw new UserException('No se pudo guardar el registro de informante, intente nuevamente');
                  }
                }
                $transaccion->commit();
                return $this->redirect(['view', 'id' => $model->codigo]);
              }else{
                throw new UserException('No se pudo guardar el registro de persona, intente nuevamente');
              }
            }catch(UserException $err){
              $transaccion->rollback();
              Yii::$app->session->setFlash('error', $err->getMessage());
              return $this->redirect(['create']);
            }
          }
        }
        return $this->render('create', ['model' => $model,]);
      }
      /**
      * Updates an existing Persona model.
      * If update is successful, the browser will be redirected to the 'view' page.
      * @param integer $id
      * @return mixed
      */
      public function actionUpdate($id)
      {
        $model = new Persona();
        $conexion = \Yii::$app->db;
        $transaccion = $conexion->beginTransaction();
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
          require_once('../auxiliar/Auxiliar.php');
          if($model->validate()){
            foreach ($model->attributes as $llave => $elemento) {
              if($model[$llave] == ''){
                $model[$llave] = null;
              }
            }
            if($_POST['nomda'] != '' && $_POST['numda'] != ''){
              $model->otro_doc = $_POST['nomda'].':'.$_POST['numda'];
            }
            $model->fecha_nacimiento = fechaMySQL($model->fecha_nacimiento);
            try{
              $informanteModel = Informante::find()->where('cod_persona = :valor',[':valor'=>$model->codigo])->one();
              if($model->save()){
                if(!empty($informanteModel)){
                  //Si tiene un informante asociada, habra que actualizarlo también
                  $informanteModel->nombre = $model->nombre.' '.$model->apellido;
                  $informanteModel->genero = $model->genero;
                  if(!empty($model->dui)){
                    $informanteModel->tipo_documento = 'Documento Único de Identidad';
                    $informanteModel->numero_documento = $model->dui;
                  }else{
                    $informanteModel->tipo_documento = $_POST['nomda'];
                    $informanteModel->numero_documento = $_POST['numda'];
                  }
                  if(!$informanteModel->save()){
                    throw new UserException('No se pudo actualizar el registro de informante asociado, intente nuevamente');
                  }
                }
                $transaccion->commit();
                return $this->redirect(['view', 'id' => $model->codigo]);
              }else{
                throw new UserException('No se pudo actualizar el registro de persona, intente nuevamente');
              }
            }catch(UserException $err){
              $transaccion->rollback();
              Yii::$app->session->setFlash('error', $err->getMessage());
              return $this->redirect(['create']);
            }
          }
        }
          return $this->render('update', ['model' => $model,]);
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
        * If the model is not found, a 404 HTTP Exception will be thrown.
        * @param integer $id
        * @return Persona the loaded model
        * @throws NotFoundHttpException if the model cannot be found
        */
        protected function findModel($id)
        {
          if (($model = Persona::findOne($id)) !== null) {
            return $model;
          } else {
            throw new NotFoundHttpException('La página solicitida no existe');
          }
        }
      }
