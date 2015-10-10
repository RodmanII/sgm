<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\filters\VerbFilter;

class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['mantenimientos','reportes'],
                'rules' => [
                    [
                        'actions' => ['mantenimientos','reportes'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback'=> function($rule,$action){
                          if(Yii::$app->user->identity->codRol->nombre != 'Administrador'){
                            throw new HttpException(403,'Esta página solo esta disponible para el usuario administrador');
                            return false;
                          }else{
                            return true;
                          }
                        }
                    ],
                    [
                        'actions' => ['mantenimientos','reportes'],
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
                    'logout' => ['post'],
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

    public function actionMantenimientos()
    {
      preg_match("/dbname=([^;]*)/", Yii::$app->db->dsn, $resultado);
      $datos = Yii::$app->db->createCommand("select table_name as tabla from information_schema.tables where
      table_schema='".$resultado[1]."' and table_name not like '%auditoria%' and table_name not like '%historico%'")->queryAll();
      $arreglo = [];
      foreach ($datos as $elemento) {
        $arreglo[$elemento['tabla']] = strtoupper(substr($elemento['tabla'],0,1)).substr($elemento['tabla'],1);
      }
      return $this->render('mantenimientos', array('data'=>$arreglo));
    }

    public function actionReportes()
    {
        return $this->render('reportes');
    }
}
