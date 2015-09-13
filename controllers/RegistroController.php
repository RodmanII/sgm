<?php

namespace app\controllers;

use Yii;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\filters\VerbFilter;
use app\models\mant\Nacimiento;
use app\models\mant\Defuncion;
use app\models\mant\Matrimonio;
use app\models\mant\MatrimonioPersona;
use app\models\mant\Partida;
use app\models\mant\Divorcio;

class RegistroController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['nacimiento','defuncion','matrimonio','divorcio','emision'],
                'rules' => [
                  [
                      'actions' => ['nacimiento','defuncion','matrimonio','divorcio','emision'],
                      'allow' => true,
                      'roles' => ['@'],
                      'matchCallback'=> function($rule,$function){
                        if(Yii::$app->user->identity->codRol->nombre=='EmpleadoRD' || Yii::$app->user->identity->codRol->nombre=='Usuario'){
                          throw new HttpException(403,'Esta página solo es accesible para los empleados de Registro Familiar');
                          //Si no lanzo una excepción podria hacer return false
                        }else{
                          return true;
                        }
                      }
                  ],
                  [
                      'actions' => ['nacimiento','defuncion','matrimonio','divorcio','emision'],
                      'allow' => false,
                      'roles' => ['?'],
                      'denyCallback'=> function($rule,$action){
                        throw new HttpException(403,'Esta página solo esta disponible para usuarios autenticados');
                      }
                  ],
              ],
          ],
          'verbs' => [
              'class' => VerbFilter::className(),
              'actions' => [
                  'nacimiento' => ['post','get'],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionNacimiento()
    {
      $model = new Nacimiento();
      $partidaModelo = new Partida();
      if ($model->load(Yii::$app->request->post()) && $partidaModelo->load(Yii::$app->request->post()) && Model::validateMultiple([$model, $partidaModelo])) {
         if ($model->validate()) {
             // form inputs are valid, do something here
             return;
         }
      }

      return $this->render('rnacimiento', ['model'=> $model,'partida'=>$partidaModelo]);
    }

    public function actionDefuncion()
    {
      $model = new Defuncion();
      $partidaModelo = new Partida();

      if ($model->load(Yii::$app->request->post()) && $partidaModelo->load(Yii::$app->request->post()) && Model::validateMultiple([$model, $partidaModelo])) {
         if ($model->validate()) {
             // form inputs are valid, do something here
             return;
         }
      }

      return $this->render('rdefuncion', ['model'=> $model,'partida'=>$partidaModelo]);
    }

    public function actionMatrimonio()
    {
      $model = new Matrimonio();
      $partidaModelo = new Partida();
      $mpersonaModelo = new MatrimonioPersona();

      if ($model->load(Yii::$app->request->post()) && $partidaModelo->load(Yii::$app->request->post())
      && $mpersonaModelo->load(Yii::$app->request->post()) && Model::validateMultiple([$model, $partidaModelo])) {
         if ($model->validate()) {
             // form inputs are valid, do something here
             return;
         }
      }

      return $this->render('rmatrimonio', ['model'=> $model,'partida'=>$partidaModelo,'mpersona'=>$mpersonaModelo]);
    }

    public function actionDivorcio()
    {
      $model = new Divorcio();
      $partidaModelo = new Partida();

      if ($model->load(Yii::$app->request->post()) && $partidaModelo->load(Yii::$app->request->post()) && Model::validateMultiple([$model, $partidaModelo])) {
         if ($model->validate()) {
             // form inputs are valid, do something here
             return;
         }
      }

      return $this->render('rdivorcio', ['model'=> $model,'partida'=>$partidaModelo]);
    }
}
