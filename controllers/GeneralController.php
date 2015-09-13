<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\filters\VerbFilter;
use app\models\mant\Municipio;

class GeneralController extends Controller
{
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'only' => ['listados'],
        'rules' => [
          [
            'actions' => ['listados'],
            'allow' => true,
            'roles' => ['@'],
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

    public function actionListados($id){
      $municipios = Municipio::find()->where(['cod_departamento' => $id])->all();

      if(count($municipios)>0){
          foreach($municipios as $municipio){
              echo "<option value='".$municipio->codigo."'>".$municipio->nombre."</option>";
          }
      }
    }
}
