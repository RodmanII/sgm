<?php

namespace app\controllers;

use Yii;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\base\UserException;
use yii\filters\VerbFilter;
use app\models\mant\Nacimiento;
use app\models\mant\Defuncion;
use app\models\mant\Matrimonio;
use app\models\mant\MatrimonioPersona;
use app\models\mant\Partida;
use app\models\mant\Divorcio;
use app\models\mant\Persona;
use app\models\mant\Hospital;
use app\models\mant\Informante;
use app\models\mant\Municipio;
use app\models\mant\Libro;
use app\models\mant\CausaDefuncion;
use app\auxiliar\NumeroALetra;
use app\auxiliar\Auxiliar;
use mPDF;

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
    $conexion = \Yii::$app->db;
    $transaccion = $conexion->beginTransaction();
    if ($model->load(Yii::$app->request->post()) && $partidaModelo->load(Yii::$app->request->post())) {
      require_once('../auxiliar/Auxiliar.php');
      $model->cod_partida = 0;
      $partidaModelo->cod_libro = 1;
      $partidaModelo->cod_empleado = Yii::$app->user->identity->persona->empleado->codigo;
      if ($model->validate() && $partidaModelo->validate()) {
        try{
          $codlibro = Libro::find()->select('codigo')->where("tipo = 'Nacimiento'")->andWhere("anyo = :an",[':an'=>date('Y')])->andWhere('numero = :valor',[':valor'=>$_POST['Partida']['num_libro']])->one()->codigo;
          $partidaModelo->cod_libro = $codlibro;
          $partidaModelo->fecha_emision = fechaMySQL($partidaModelo->fecha_emision);
          $partidaModelo->fecha_suceso = fechaMySQL($partidaModelo->fecha_suceso);
          $partidaModelo->hora_suceso = horaMySQL($partidaModelo->hora_suceso);
          if($partidaModelo->save()){
            //Recupero el valor de id con el cual se inserto
            $ulid = $conexion->getLastInsertID();
            $model->cod_partida = $ulid;
            //Guardo el registro de nacimiento
            if(!$model->save()){
              throw new UserException('No se pudo guardar el registro de nacimiento, intente nuevamente');
            }
            //Actualizar el folio actual del libro
            if($conexion->createCommand("update libro set folio_actual = folio_actual + 1 where codigo = ".$codlibro)->execute()<=0){
              throw new UserException('No se pudo actualizar el libro de partidas, intente nuevamente');
            }
            $transaccion->commit();
            Yii::$app->session->setFlash('success', 'Partida guardada con éxito');
            return $this->redirect(['nacimiento']);
          }else{
            throw new UserException('No se pudo guardar el registro de partida, intente nuevamente');
          }
          return;
        }catch(UserException $err){
            $transaccion->rollback();
            Yii::$app->session->setFlash('error', $err->getMessage());
            return $this->redirect(['nacimiento']);
        }
      }else{
        Yii::$app->session->setFlash('error', 'El modelo no cumple con la validación');
      }
    }
    return $this->render('rnacimiento', ['model'=> $model,'partida'=>$partidaModelo]);
  }

  public function actionGenerar($tipo,$guardar,$parametros){
    require_once('../auxiliar/Auxiliar.php');
    $guardar = filter_var($guardar, FILTER_VALIDATE_BOOLEAN);
    $destino = 'I';
    if($guardar){
      $destino = 'F';
    }
    $conversor = new NumeroALetra();
    $param = obtenerParams($parametros);
    $nombre = 'Partida de '.$tipo.'.pdf';
    $nomInscrito = '';
    $estilos = file_get_contents('../web/css/partidas.css');
    $mpdf = new mPDF('','Letter');
    $mpdf->WriteHTML($estilos,1);
    $mpdf->WriteHTML('<p class="centrado">www.alcaldiadeilopango.gob.sv</p>');
    $mpdf->WriteHTML('<div class="clalcaldia">
    <img src="../web/images/LogoAlcaldia.jpg" class="imgcab"/>
    </div>');
    $mpdf->WriteHTML('<p class="centrado titular">Alcaldía Municipal de Ilopango</p>');
    $mpdf->WriteHTML('<div class="cescudo">
    <img src="../web/images/EscudoSalvador.png" class="imgcab"/>
    </div>');
    $mpdf->WriteHTML('<p class="centrado">Ave. Miguel Mármol y Calle Francisco Menéndez, Ilopango</p>');
    $mpdf->WriteHTML('<p class="centrado">TELEFAX 2536-5215</p>');
    $mpdf->WriteHTML('<hr/>');
    $mpdf->WriteHTML('<p class="centrado cabecera">ALCALDÍA MUNICIPAL DE ILOPANGO</p>');
    $tiempo = explode(':',date('G:i',strtotime($param['hora_suceso'])));
    $minutos = 'cero';
    if($tiempo[1]!='00'){
      $minutos = $conversor->to_word($tiempo[1],null,true);
    }
    switch ($tipo) {
      case 'nacimiento':
      $mpdf->WriteHTML('<p class="centrado cabecera">LIBRO DE PARTIDAS DE NACIMIENTO NÚMERO '.$conversor->to_word($param['num_libro'],null,false,true).' DEL</p>');
      $mpdf->WriteHTML('<p class="centrado cabecera">AÑO '.$conversor->to_word(date('Y')).'</p>');
      $mpdf->WriteHTML('<p class="derecha cabecera">FOLIO '.$conversor->to_word($param['folio']).'</p>');
      $mpdf->WriteHTML('<p class="centrado">DATOS DEL INSCRITO</p>');
      $dbAsentado = Persona::find()->where('codigo = '.$param['cod_asentado'])->one();
      $dbHospital = Hospital::find()->where('codigo = '.$param['cod_hospital'])->one();
      $dbMunicipio = Municipio::find()->where('codigo = '.$param['cod_municipio'])->one();
      //Aqui estaba el codigo para recuperar el tiempo, se coloca antes del switch porque figura en cada documento
      $nomInscrito = $dbAsentado->nombre.' '.$dbAsentado->apellido;
      $mpdf->WriteHTML('<p class="justificado">Partida Número '.trim($conversor->to_word($param['codigo'],null,true,true)).'; <strong>'.$dbAsentado->nombre.'</strong>.- sexo '
      .strtolower($dbAsentado->genero).', nació en el '.$dbHospital->nombre.' '.$param['lugar_suceso'].', Municipio de '
      .$dbMunicipio->nombre.', Departamento de '.$dbMunicipio->codDepartamento->nombre.', a las '.$conversor->to_word($tiempo[0],null,true).' horas '.$minutos.' minutos
      del día '.fechaATexto($param['fecha_suceso']).'.</p>');

      $arreglo = [];
      $parentesco = [];
      $iteraciones = 0;
      if($param['cod_madre']!=''){
        array_push($arreglo,'cod_madre');
        array_push($parentesco,'DE LA MADRE');
        $iteraciones++;
      }
      if($param['cod_padre']!=''){
        array_push($arreglo,'cod_padre');
        array_push($parentesco,'DEL PADRE');
        $iteraciones++;
      }
      for($i = 0;$i < $iteraciones;$i++){
        $dbProgenitor = Persona::find()->where('codigo = '.$param[$arreglo[$i]])->one();
        if($dbProgenitor->dui!=null){
          $tipo_doc = 'Documento Único de Identidad';
          $num_doc = $dbProgenitor->dui;
        }else{
          $arr = explode(':',$dbProgenitor->otro_doc);
          $tipo_doc = $arr[0];
          $num_doc = $arr[1];
        }
        $mpdf->WriteHTML('<p class="centrado">DATOS '.$parentesco[$i].'</p>');
        $edad = calcularEdad($dbProgenitor->fecha_nacimiento);
        $indicador = 'a';
        if($dbProgenitor->genero=='Masculino'){
          $indicador = 'o';
        }
        $mpdf->WriteHTML('<p class="justificado"><strong>'.$dbProgenitor->nombre.' '.$dbProgenitor->apellido.'</strong> de '.$conversor->to_word($edad,null,true).'
        años de edad, profesión u oficio, '.strtolower($dbProgenitor->profesion).', originari'.$indicador.' de '.$dbProgenitor->codMunicipio->nombre.',
        Departamento de '.$dbProgenitor->codMunicipio->codDepartamento->nombre.', del domicilio de '.$dbProgenitor->direccion.',
        de Nacionalidad '.$dbProgenitor->codNacionalidad->nombre.', quién se identifica por medio de '.$tipo_doc.'
        número; '.$conversor->convertirSeparado($num_doc).'.</p>');
      }
      $indicador = 'de la inscrita';
      $comp = 'a';
      if($dbAsentado->genero=='Masculino'){
        $indicador = 'del inscrito';
        $comp = 'o';
      }
      $tipo_ase = 'Plantares de Recién Nacid'.$comp;
      $dbInformante = Informante::find()->where('codigo = '.$param['cod_informante'])->one();
      $mpdf->WriteHTML('<p class="centrado">DATOS DEL INFORMANTE</p>');
      $mpdf->WriteHTML('<p class="justificado">Dio los datos; <strong>'.$dbInformante->nombre.'</strong>, quién se identifica por medio de '
      .$dbInformante->tipo_documento.' número; '.$conversor->convertirSeparado($dbInformante->numero_documento).'. Manifestando ser '.$param['rel_informante'].'
      '.$indicador.' y para constancia firma, se asienta con base a '.$tipo_ase.' de fecha '.fechaATexto($param['fecha_suceso']).'.
      Alcaldía Municipal de Ilopango, '.fechaATexto($param['fecha_emision']).'.</p>');

      $mpdf->WriteHTML('<p id="finforl" class="firmal">F._________________________</p><p id="fjrfl" class="firmal">F._______________________________________</p>');
      $mpdf->WriteHTML('<p id="finfort" class="firmat">Firma del Informante</p><p id="fjrft" class="firmat">Jefe del Registro del Estado Familiar</p>');
      break;
      case 'defuncion':
        $mpdf->WriteHTML('<p class="centrado cabecera">LIBRO DE PARTIDAS DE DEFUNCIÓN NÚMERO '.$conversor->to_word($param['num_libro'],null,false,true).' DEL</p>');
        $mpdf->WriteHTML('<p class="centrado cabecera">AÑO '.$conversor->to_word(date('Y')).'</p>');
        $mpdf->WriteHTML('<p class="derecha cabecera">FOLIO '.$conversor->to_word($param['folio']).'</p>');
        $mpdf->WriteHTML('<p class="centrado">DATOS DEL FALLECIDO</p>');
        $dbDifunto = Persona::find()->where('codigo = '.$param['cod_difunto'])->one();
        $dbCausa = CausaDefuncion::find()->where('codigo = '.$param['cod_causa'])->one();
        $dbInformante = Informante::find()->where('codigo = '.$param['cod_informante'])->one();
        $nomInscrito = $dbDifunto->nombre.' '.$dbDifunto->apellido;
        if($dbDifunto->dui!=null){
          $tipo_doc = 'Documento Único de Identidad';
          $num_doc = $dbDifunto->dui;
        }else{
          $arr = explode(':',$dbDifunto->otro_doc);
          $tipo_doc = $arr[0];
          $num_doc = $arr[1];
        }
        $mpdf->WriteHTML('<p class="justificado">Partida Número '.trim($conversor->to_word($param['codigo'],null,true,true)).'; <strong>'.$dbDifunto->nombre.' '.$dbDifunto->apellido.'</strong>.- sexo '
        .strtolower($dbDifunto->genero).', de '.$conversor->to_word(calcularEdad($dbDifunto->fecha_nacimiento),null,true).' años de edad; Profesión u Oficio; '.$dbDifunto->profesion.'; Estado Familiar: '.$dbDifunto->codEstadoCivil->nombre.';'
        .' Del domicilio de '.$dbDifunto->direccion.', de Nacionalidad '.$dbDifunto->codNacionalidad->nombre.', Documento de Identidad del Fallecido: '.$tipo_doc.'; Documento Número '
        .$conversor->convertirSeparado($num_doc).'. Falleció en el '.$param['lugar_suceso'].', a las '.$conversor->to_word($tiempo[0],null,true).' horas '.$minutos.' minutos del día '
        .fechaATexto($param['fecha_suceso']).' Causa del fallecimiento: '.$dbCausa->nombre.'. Nombre del profesional quién determino la causa: '
        .$param['determino_causa'].'.</p>');

        $mpdf->WriteHTML('<p class="centrado">DATOS FAMILIARES</p>');
        $arrfam = explode('-',$param['familiares']);
        $indinf = 'El';
        if($dbInformante->genero=='Femenino'){
          $indinf = 'La';
        }
        for($i = 0;$i < count($arrfam);$i++){
          $elemento = explode(':',$param['familiares']);
          $indicador = 'del';
          if($elemento[1][0].$elemento[1][1] == 'Ma' || substr($elemento[1],-1) == 'a'){
            $indicador = 'de la';
          }
          $mpdf->WriteHTML('<p class="justificado">Nombre '.$indicador.' '.$elemento[1].': '.$elemento[0].' </p>');
        }
        $mpdf->WriteHTML('<p class="centrado">DATOS DEL INFORMANTE</p>');
        $mpdf->WriteHTML('<p class="justificado">Dio los datos; <strong>'.$dbInformante->nombre.'</strong>, quién se identifica por medio de '
        .$dbInformante->tipo_documento.' número; '.$conversor->convertirSeparado($dbInformante->numero_documento).'. '.$indinf.'. informante manifiesta '
        .'que está de acuerdo con los datos consignados y para constancia firma. Alcaldía Municipal de Ilopango, '.fechaATexto($param['fecha_emision']).'.</p>');

        $mpdf->WriteHTML('<p id="finforl" class="firmal">F._________________________</p><p id="fjrfl" class="firmal">F._______________________________________</p>');
        $mpdf->WriteHTML('<p id="finfort" class="firmat">Firma del Informante</p><p id="fjrft" class="firmat">Jefe del Registro del Estado Familiar</p>');
      break;
      case 'matrimonio':
      break;
      case 'divorcio':
      break;
      default:
      # code...
      break;
    }
    $script = '';
    if($guardar){
      $dirdestino = Yii::getAlias('@webroot').'/../partidas/'.$tipo.'/'.date('Y').'/'.$param['num_libro'].'/';
      if (!file_exists($dirdestino)) {
        mkdir($dirdestino, 0777, true);
      }
      $nombre = $dirdestino.$nomInscrito.'.pdf';
      $script = '<script type="text/javascript">window.close()</script>';
    }
    $mpdf->Output(utf8_decode($nombre),$destino);
    echo $script;
    exit;
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
