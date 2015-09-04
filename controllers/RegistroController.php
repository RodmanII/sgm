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
use app\models\mant\Partida;

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
                        if(Yii::$app->user->identity->codRol->nombre=='EmpleadoRD'){
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
}