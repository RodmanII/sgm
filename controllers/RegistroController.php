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
use app\models\mant\ModalidadDivorcio;
use app\models\mant\RegimenPatrimonial;
use app\models\mant\Partida;
use app\models\mant\Divorcio;
use app\models\mant\Persona;
use app\models\mant\Hospital;
use app\models\mant\Informante;
use app\models\mant\Municipio;
use app\models\mant\Libro;
use app\models\mant\Empleado;
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
    if($model->load(Yii::$app->request->post()) && $partidaModelo->load(Yii::$app->request->post())){
      require_once('../auxiliar/Auxiliar.php');
      $partidaModelo->cod_empleado = Yii::$app->user->identity->persona->codEmpleado->codigo;
      $partidaModelo->tipo = "Nacimiento";
      $model->cod_partida = 0;
      $model->edad_padre = calcularEdad(Persona::find()->where('codigo = '.$model->cod_padre)->one()->fecha_nacimiento);
      $model->edad_madre = calcularEdad(Persona::find()->where('codigo = '.$model->cod_madre)->one()->fecha_nacimiento);
      $codlibro = Libro::find()->select('codigo')->where("tipo = 'Nacimiento'")->andWhere("anyo = :an",[':an'=>date('Y')])->andWhere('numero = :valor',[':valor'=>$_POST['Partida']['num_libro']])->one()->codigo;
      $partidaModelo->cod_libro = $codlibro;
      if($model->validate() && $partidaModelo->validate()){
        try{
          $partidaModelo->fecha_emision = fechaMySQL($partidaModelo->fecha_emision);
          $partidaModelo->fecha_suceso = fechaMySQL($partidaModelo->fecha_suceso);
          $partidaModelo->hora_suceso = horaMySQL($partidaModelo->hora_suceso);
          // $partidaModelo->numero = $_POST['Partida']['numero'];
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

  public function actionGenerar($tipo,$guardar,$parametros,$nueva = true){
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
    $objTPar = null;
    $objPartida = null;
    if(!$nueva){
      switch ($tipo) {
        case 'nacimiento':
          $objTPar = Nacimiento::find()->where('codigo = '.$param['codtpar'])->one();
          break;
        case 'defuncion':
          $objTPar = Defuncion::find()->where('codigo = '.$param['codtpar'])->one();
          break;
        case 'matrimonio':
          $objTPar = Matrimonio::find()->where('codigo = '.$param['codtpar'])->one();
          break;
        case 'divorcio':
          $objTPar = Divorcio::find()->where('codigo = '.$param['codtpar'])->one();
          break;
        default:
          exit('Algo no anda bien');
          break;
      }
      foreach ($param as $llave => $valor) {
        if(property_exists($objTPar,$llave)){
          $param[$llave] = $objTPar[$llave];
        }
      }
      $objPartida = Partida::find()->where('codigo = '.$objTPar->cod_partida)->one();
      foreach ($param as $llave => $valor) {
        if(property_exists($objPartida,$llave)){
          $param[$llave] = $objPartida[$llave];
        }
      }
    }
    $tiempo = explode(':',date('G:i',strtotime($param['hora_suceso'])));
    $minutos = 'cero';
    if($tiempo[1]!='00'){
      $minutos = $conversor->to_word($tiempo[1],null,true);
    }
    $dbJrf = Empleado::find()->where("cargo = 'JREF'")->one();
    $titulo = '';
    if($dbJrf->codPersona->genero == 'Masculino'){
      $titulo = "Jefe ";
    }else{
      $titulo = "Jefa ";
    }
    $jref = $dbJrf->codPersona->nombre.' '.$dbJrf->codPersona->apellido;
    switch ($tipo) {
      case 'nacimiento':
        $mpdf->WriteHTML('<p class="centrado cabecera">LIBRO DE PARTIDAS DE NACIMIENTO NÚMERO '.$conversor->to_word($param['num_libro'],null,false,true).' DEL</p>');
        $mpdf->WriteHTML('<p class="centrado cabecera">AÑO '.$conversor->to_word(date('Y')).'</p>');
        $mpdf->WriteHTML('<p class="derecha cabecera">FOLIO '.$conversor->to_word($param['folio']).'</p>');
        $mpdf->WriteHTML('<p class="centrado">DATOS DEL INSCRITO</p>');
        $dbAsentado = Persona::find()->where('codigo = '.$param['cod_asentado'])->one();
        if($param['doc_presentado']=='Plantares de Recién Nacid'){
          $dbHospital = Hospital::find()->where('codigo = '.$param['cod_hospital'])->one();
        }else{
          $dbHospital = new Hospital();
          $dbHospital->nombre = '';
        }
        $dbMunicipio = Municipio::find()->where('codigo = '.$param['cod_municipio'])->one();
        //Aqui estaba el codigo para recuperar el tiempo, se coloca antes del switch porque figura en cada documento
        $nomInscrito = $dbAsentado->nombre.' '.$dbAsentado->apellido;
        $mpdf->WriteHTML('<p class="justificado">Partida Número '.trim($conversor->to_word($param['numero'],null,true,true)).'; <strong>'.$dbAsentado->nombre.'</strong>.- sexo '
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
          if($dbProgenitor->otro_doc!=null){
            $arr = explode(':',$dbProgenitor->otro_doc);
            $tipo_doc = $arr[0];
            $num_doc = $arr[1];
          }else{
            $tipo_doc = 'Documento Único de Identidad';
            $num_doc = $dbProgenitor->dui;
          }
          $mpdf->WriteHTML('<p class="centrado">DATOS '.$parentesco[$i].'</p>');
          $edad = '';
          if(!$nueva){
            $temp = end(explode('_',$arreglo[$i]));
            $llave = 'edad_'.$temp;
            $edad = $objTPar[$llave];
          }else{
            $edad = calcularEdad($dbProgenitor->fecha_nacimiento);
          }
          $indicador = 'a';
          if($dbProgenitor->genero=='Masculino'){
            $indicador = 'o';
          }
          $mpdf->WriteHTML('<p class="justificado"><strong>'.$dbProgenitor->nombre.' '.$dbProgenitor->apellido.'</strong> de '.$conversor->to_word($edad,null,true).'
          años de edad, profesión u oficio, '.strtolower($dbProgenitor->profesion).', originari'.$indicador.' de '.$dbProgenitor->codMunOrigen->nombre.',
          Departamento de '.$dbProgenitor->codMunOrigen->codDepartamento->nombre.', del domicilio de '.$dbProgenitor->direccion.',
          de Nacionalidad '.$dbProgenitor->codNacionalidad->nombre.', quién se identifica por medio de '.$tipo_doc.'
          número; '.$conversor->convertirSeparado($num_doc).'.</p>');
        }
        $indicador = 'de la inscrita';
        $comp = 'a';
        if($dbAsentado->genero=='Masculino'){
          $indicador = 'del inscrito';
          $comp = 'o';
        }
        $tipo_ase = $param['doc_presentado'];
        if(reset(explode(' ',$param['doc_presentado']))=='Plantares'){
          $tipo_ase.= $comp;
        }
        $dbInformante = Informante::find()->where('codigo = '.$param['cod_informante'])->one();
        $mpdf->WriteHTML('<p class="centrado">DATOS DEL INFORMANTE</p>');
        $mpdf->WriteHTML('<p class="justificado">Dio los datos; <strong>'.$dbInformante->nombre.'</strong>, quién se identifica por medio de '
        .$dbInformante->tipo_documento.' número; '.$conversor->convertirSeparado($dbInformante->numero_documento).'. Manifestando ser '.$param['rel_informante'].'
        '.$indicador.' y para constancia firma, se asienta con base a '.$tipo_ase.' de fecha '.fechaATexto($param['fecha_suceso']).'.
        Alcaldía Municipal de Ilopango, '.fechaATexto($param['fecha_emision']).'.</p>');
        $firmai = strtolower($dbInformante->genero).'/'.$dbInformante->firma;
        $mpdf->WriteHTML('<p id="finfori" class="firmal"><img style="width:220px;" src="../firmas/'.$firmai.'" /></p><p id="fjrfi" class="firmal"><img style="width:220px;" src="../web/images/firma_jref.png" /></p>');
        $mpdf->WriteHTML('<p id="finforl" class="firmal">F._________________________</p><p id="fjrfl" class="firmal">F._______________________________________</p>');
        $mpdf->WriteHTML('<p id="finfort" class="firmat">Firma del Informante</p><p id="fjrft" class="firmat">'.$titulo.'del Registro del Estado Familiar</p>');
      break;
      case 'defuncion':
        $mpdf->WriteHTML('<p class="centrado cabecera">LIBRO DE PARTIDAS DE DEFUNCIÓN NÚMERO '.$conversor->to_word($param['num_libro'],null,false,true).' DEL</p>');
        $mpdf->WriteHTML('<p class="centrado cabecera">AÑO '.$conversor->to_word(date('Y')).'</p>');
        $mpdf->WriteHTML('<p class="derecha cabecera">FOLIO '.$conversor->to_word($param['folio']).'</p>');
        $mpdf->WriteHTML('<p class="centrado">DATOS DEL FALLECIDO</p>');
        $dbDifunto = Persona::find()->where('codigo = '.$param['cod_difunto'])->one();
        $dbCausa = CausaDefuncion::find()->where('codigo = '.$param['cod_causa'])->one();
        $dbInformante = Informante::find()->where('codigo = '.$param['cod_informante'])->one();
        $dbMunicipio = Municipio::find()->where('codigo = '.$param['cod_municipio'])->one();
        $nomInscrito = $dbDifunto->nombre.' '.$dbDifunto->apellido;
        if($dbDifunto->dui!=null){
          $compDoc = 'Documento Único de Identidad; Documento Número '.$conversor->convertirSeparado($dbDifunto->dui);
        }else{
          $compDoc = 'Partida de Nacimiento de la Alcaldía de '.$param['alc_partida'].', '.$param['datos_partida'];
        }
        $indicador = 'a';
        if($dbDifunto->genero=='Masculino'){
          $indicador = 'o';
        }
        $asistido = 'sin';
        if($param['con_asistencia']){
          $asistido = 'con';
        }
        $estCivil = substr($dbDifunto->codEstadoCivil->nombre, 0, -1).$indicador;
        $mpdf->WriteHTML('<p class="justificado">Partida Número '.trim($conversor->to_word($param['numero'],null,true,true)).'; <strong>'.$dbDifunto->nombre.' '.$dbDifunto->apellido.'</strong>.- sexo '
        .strtolower($dbDifunto->genero).', de '.$conversor->to_word(calcularEdad($dbDifunto->fecha_nacimiento,$param['fecha_suceso']),null,true).' años de edad; Profesión u Oficio; '.$dbDifunto->profesion.'; Estado Familiar: '.$estCivil.'; '
        .'Originari'.$indicador.' de '.$dbDifunto->codMunOrigen->nombre.', Departamento de '.$dbDifunto->codMunOrigen->codDepartamento->nombre.', del domicilio de '.$dbDifunto->direccion.', de Nacionalidad '
        .$dbDifunto->codNacionalidad->nombre.', Documento de Identidad del Fallecido: '.$compDoc.'. Falleció en '.$param['lugar_suceso'].'. '.$dbMunicipio->nombre.', Departamento de '.$dbMunicipio->codDepartamento->nombre.', a las '.$conversor->to_word($tiempo[0],null,true).' horas '.$minutos.' minutos del día '
        .fechaATexto($param['fecha_suceso']).', '.$asistido.' Asistencia Médica, Causa del fallecimiento: '.$dbCausa->nombre.'. Nombre del profesional quién determino la causa: '
        .$param['determino_causa'].'.</p>');

        $mpdf->WriteHTML('<p class="centrado">DATOS FAMILIARES</p>');
        $mpdf->WriteHTML('<br/>');
        $arrfam = explode('-',$param['familiares']);
        $indinf = 'El';
        if($dbInformante->genero=='Femenino'){
          $indinf = 'La';
        }
        for($i = 0;$i < count($arrfam);$i++){
          $elemento = explode(':',$arrfam[$i]);
          $indicador = 'del';
          if($elemento[1][0].$elemento[1][1] == 'Ma' || substr($elemento[1],-1) == 'a'){
            $indicador = 'de la';
          }
          $mpdf->WriteHTML('<p class="justificado smargen">Nombre '.$indicador.' '.$elemento[1].': '.$elemento[0].' </p>');
        }
        $mpdf->WriteHTML('<br/>');
        $mpdf->WriteHTML('<p class="centrado">DATOS DEL INFORMANTE</p>');
        $mpdf->WriteHTML('<p class="justificado">Dio los datos: <strong>'.$dbInformante->nombre.'</strong>, quién se identifica por medio de '
        .$dbInformante->tipo_documento.' número; '.$conversor->convertirSeparado($dbInformante->numero_documento).'. '.$indinf.' informante manifiesta '
        .'que está de acuerdo con los datos consignados y para constancia firma. Alcaldía Municipal de Ilopango, '.fechaATexto($param['fecha_emision']).'.</p>');
        $firmai = strtolower($dbInformante->genero).'/'.$dbInformante->firma;
        $mpdf->WriteHTML('<p id="finfori" class="firmal"><img style="width:220px;" src="../firmas/'.$firmai.'" /></p><p id="fjrfi" class="firmal"><img style="width:220px;" src="../web/images/firma_jref.png" /></p>');
        $mpdf->WriteHTML('<p id="finforl" class="firmal">F._________________________</p><p id="fjrfl" class="firmal">F._______________________________________</p>');
        $mpdf->WriteHTML('<p id="finfort" class="firmat">Firma del Informante</p><p id="fjrft" class="firmat">'.$titulo.'del Registro del Estado Familiar</p>');
      break;
      case 'matrimonio':
        $mpdf->WriteHTML('<p class="centrado cabecera">LIBRO DE PARTIDAS DE MATRIMONIO NÚMERO '.$conversor->to_word($param['num_libro'],null,false,true).' DEL</p>');
        $mpdf->WriteHTML('<p class="centrado cabecera">AÑO '.$conversor->to_word(date('Y')).'</p>');
        $mpdf->WriteHTML('<p class="derecha cabecera">FOLIO '.$conversor->to_word($param['folio']).'</p>');
        $dbConh = Persona::find()->where('codigo = '.$param['cod_conhom'])->one();
        $dbConm = Persona::find()->where('codigo = '.$param['cod_conmuj'])->one();
        $nomConh = $dbConh->nombre.' '.$dbConh->apellido;
        $nomConm = $dbConm->nombre.' '.$dbConm->apellido;
        $indicador = 'del notario';
        if($param['gen_notario']=='Femenino'){
          $indicador = 'de la notaria';
        }
        $nomInscrito = $dbConh->nombre.' '.$dbConh->apellido.'-'.$dbConm->nombre.' '.$dbConm->apellido;
        $complemento = '';
        if($param['apellido_casada']!=''){
          $ape = strtok($dbConm->apellido, " ");
          $complemento = 'El nombre que la contrayente usará de conformidad al artículo ventiuno de la Ley del Nombre de la Persona Natural será: <strong>'.$dbConm->nombre.' '.$ape.' '.$param['apellido_casada'].'</strong>.';
        }
        $pahom = '';
        if($param['madre_contrayente_h']!=''){
          $pahom = 'Hijo de la Señora: '.$param['madre_contrayente_h'];
          if($param['padre_contrayente_h']!=''){
            $pahom .= ' y del Señor: '.$param['padre_contrayente_h'];
          }
        }else{
          $pahom = 'Hijo del Señor: '.$param['padre_contrayente_h'];
        }
        $pamuj = '';
        if($param['madre_contrayente_m']!=''){
          $pamuj = 'Hija de la Señora: '.$param['madre_contrayente_m'];
          if($param['padre_contrayente_m']!=''){
            $pamuj .= ' y del Señor: '.$param['padre_contrayente_m'];
          }
        }else{
          $pamuj = 'Hija del Señor: '.$param['padre_contrayente_m'];
        }
        $dbConm->codEstadoCivil->nombre = rtrim($dbConm->codEstadoCivil->nombre,'o').'a';
        $testigos = explode('-',$param['testigos']);
        $reg_pat = RegimenPatrimonial::find()->where('codigo = '.$param['cod_reg_patrimonial'])->one()->nombre;
        $mpdf->WriteHTML('<p class="justificado" style="font-size:16.5px">Partida Número '.trim($conversor->to_word($param['numero'],null,true,true)).': <strong>'.$nomConh.' y '.$nomConm.'</strong>. El Contrayente de '
        .$conversor->to_word(calcularEdad($dbConh->fecha_nacimiento,$param['fecha_suceso']),null,true).' años de edad, '.(($dbConh->empleado) ? 'Empleado':'Desempleado').', '.$dbConh->codEstadoCivil->nombre.', '
        .'originario de '.$dbConh->codMunOrigen->nombre.', Departamento de '.$dbConh->codMunOrigen->codDepartamento->nombre.', del Domicilio de '.$dbConh->direccion.', de Nacionalidad '.$dbConh->codNacionalidad->nombre.', '
        .$pahom.', la Contrayente: de '.$conversor->to_word(calcularEdad($dbConm->fecha_nacimiento,$param['fecha_suceso']),null,true).' años de edad, '
        .(($dbConm->empleado) ? 'Empleada':'Desempleada').', '.$dbConm->codEstadoCivil->nombre.', originaria de '.$dbConm->codMunOrigen->nombre.', Departamento de '.$dbConm->codMunOrigen->codDepartamento->nombre.', del Domicilio de '.$dbConm->direccion.', de Nacionalidad '
        .$dbConm->codNacionalidad->nombre.', '.$pamuj.'. Contrajeron matrimonio en la ciudad de Ilopango, Departamento de San Salvador, ante los oficios '
        .$indicador.' '.$param['notario'].'. Según escritura pública de matrimonio número: '.$conversor->to_word($param['num_etr_publica'],null,true).', otorgada a las '.$conversor->to_word($tiempo[0],null,true).' horas '.$minutos.' minutos del día '
        .fechaATexto($param['fecha_suceso']).', con asistencia de los testigos: '.$testigos[0].' y '.$testigos[1].'. '.$complemento
        .' Para la administración de sus bienes optaron por el Régimen Patrimonial de: <strong>'.$reg_pat.'</strong>. Alcaldía Municipal de Ilopango, '.fechaATexto($param['fecha_emision']).'.</p>');
        $mpdf->WriteHTML('<br/>');
        $mpdf->WriteHTML('<br/>');
        $mpdf->WriteHTML('<div class="firmadm">
        <img src="../web/images/firma_jref.png" />
        </div>');
        $mpdf->WriteHTML('<p class="centrado" style="font-size:16.5px">Lic. '.$jref.'</p>');
        $mpdf->WriteHTML('<p class="centrado" style="font-size:16.5px">'.$titulo.' del Registro del Estado Familiar</p>');
      break;
      case 'divorcio':
        $mpdf->WriteHTML('<p class="centrado cabecera">LIBRO DE PARTIDAS DE DIVORCIO NÚMERO '.$conversor->to_word($param['num_libro'],null,false,true).' DEL</p>');
        $mpdf->WriteHTML('<p class="centrado cabecera">AÑO '.$conversor->to_word(date('Y')).'</p>');
        $mpdf->WriteHTML('<p class="derecha cabecera">FOLIO '.$conversor->to_word($param['folio']).'</p>');
        $dbMatp = MatrimonioPersona::find()->where('cod_matrimonio = '.$param['cod_matrimonio'])->all();
        $dbConh = $dbMatp[0]->codPersona;
        $dbConm = $dbMatp[1]->codPersona;
        $nomConh = $dbConh->nombre.' '.$dbConh->apellido;
        $nomConm = $dbConm->nombre.' '.$dbConm->apellido;
        $nomInscrito = $dbConh->nombre.' '.$dbConh->apellido.'-'.$dbConm->nombre.' '.$dbConm->apellido;
        $pahom = '';
        if($dbMatp[0]->codMatrimonio->madre_contrayente_h!=null){
          $pahom = 'Hijo de la Señora: '.$dbMatp[0]->codMatrimonio->madre_contrayente_h;
          if($dbMatp[0]->codMatrimonio->padre_contrayente_h!=null){
            $pahom .= ' y del Señor: '.$dbMatp[0]->codMatrimonio->padre_contrayente_h;
          }
        }else{
          $pahom = 'Hijo del Señor: '.$dbMatp[0]->codMatrimonio->padre_contrayente_h;
        }
        $pamuj = '';
        if($dbMatp[0]->codMatrimonio->madre_contrayente_m!=null){
          $pamuj = 'Hija de la Señora: '.$dbMatp[0]->codMatrimonio->madre_contrayente_m;
          if($dbMatp[0]->codMatrimonio->padre_contrayente_m!=null){
            $pamuj .= ' y del Señor: '.$dbMatp[0]->codMatrimonio->padre_contrayente_m;
          }
        }else{
          $pamuj = 'Hija del Señor: '.$dbMatp[0]->codMatrimonio->padre_contrayente_m;
        }
        $tiempo = explode(':',$dbMatp[0]->codMatrimonio->codPartida->hora_suceso);
        $minutos = 'cero';
        if($tiempo[1]!='00'){
          $minutos = $conversor->to_word($tiempo[1],null,true);
        }
        $tiempoD = explode(':',date('G:i',strtotime($param['hora_suceso'])));
        $minutosD = 'cero';
        if($tiempoD[1]!='00'){
          $minutosD = $conversor->to_word($tiempoD[1],null,true);
        }
        if($param['detalle']!=''){
          $param['detalle'].='.';
        }
        $modalidad = ModalidadDivorcio::find()->where('codigo = '.$param['cod_mod_divorcio'])->one()->nombre;
        $municipio = Municipio::find()->where('codigo = '.$param['cod_municipio'])->one();
        $dbConm->codEstadoCivil->nombre = rtrim($dbConm->codEstadoCivil->nombre,'o').'a';
        $testigos = explode('-',$dbMatp[0]->codMatrimonio->testigos);
        $reg_pat = $dbMatp[0]->codMatrimonio->codRegPatrimonial->nombre;
        $mpdf->WriteHTML('<p class="justificado" style="font-size:16.5px">Partida Número '.trim($conversor->to_word($param['codigo'],null,true,true)).': <strong>'.$nomConh.' y '.$nomConm.'</strong>. El Contrayente de '
        .$conversor->to_word(calcularEdad($dbConh->fecha_nacimiento),null,true).' años de edad, '.(($dbConh->empleado) ? 'Empleado':'Desempleado').', '.$dbConh->codEstadoCivil->nombre.', '
        .'originario de '.$dbConh->codMunOrigen->nombre.', Departamento de '.$dbConh->codMunOrigen->codDepartamento->nombre.', del Domicilio de '.$dbConh->direccion.', de Nacionalidad '.$dbConh->codNacionalidad->nombre.', '
        .$pahom.', la Contrayente: de '.$conversor->to_word(calcularEdad($dbConm->fecha_nacimiento),null,true).' años de edad, '
        .(($dbConm->empleado) ? 'Empleada':'Desempleada').', '.$dbConm->codEstadoCivil->nombre.', originaria de '.$dbConm->codMunOrigen->nombre.', Departamento de '.$dbConm->codMunOrigen->codDepartamento->nombre.', del Domicilio de '.$dbConm->direccion.', de Nacionalidad '
        .$dbConm->codNacionalidad->nombre.', '.$pamuj.'. Contrajeron matrimonio en la ciudad de Ilopango, Departamento de San Salvador, ante los oficios de: '
        .$dbMatp[0]->codMatrimonio->notario.'. Según escritura pública de matrimonio número: '.$conversor->to_word($dbMatp[0]->codMatrimonio->num_etr_publica,null,true).', otorgada a las '.$conversor->to_word($tiempo[0],null,true).' horas '.$minutos.' minutos del día '
        .fechaATexto(fechaComun($dbMatp[0]->codMatrimonio->codPartida->fecha_suceso)).', con asistencia de los testigos: '.$testigos[0].' y '.$testigos[1].'. '
        .' Según partida de matrimonio número: '.$conversor->to_word($dbMatp[0]->codMatrimonio->codigo,null,true,true).', folio '.$conversor->to_word($dbMatp[0]->codMatrimonio->codPartida->folio,null,true).', del libro de partidas de matrimonio '
        .$conversor->to_word($dbMatp[0]->codMatrimonio->codPartida->codLibro->numero,null,true,true).' del año '.$conversor->to_word($dbMatp[0]->codMatrimonio->codPartida->codLibro->anyo,null,true).'. <strong>Se ha decretado el divorcio: </strong>'
        .'Por '.$modalidad.', declarándose disuelto el vínculo matrimonial que los unía, por medio de sentencia definitiva de divorcio, pronunciada por: '.$param['juez'].' de '.$municipio->nombre.', Departamento de '.$municipio->codDepartamento->nombre.' a las '.$conversor->to_word($tiempoD[0],null,true).' horas '.$minutosD.' minutos '
        .'del día '.fechaATexto($param['fecha_suceso']).' y ejecutoriada el día '.fechaATexto($param['fecha_ejecucion']).'. '
        .$param['detalle'].' Por lo tanto se cancela la partida de matrimonio relacionada. Alcaldía Municipal de Ilopango, '.fechaATexto($param['fecha_emision']).'.</p>');
        //obtener el nombre de la modalidad
        $mpdf->WriteHTML('<br/>');
        $mpdf->WriteHTML('<br/>');
        $mpdf->WriteHTML('<div class="firmadm">
        <img src="../web/images/firma_jref.png" />
        </div>');
        $mpdf->WriteHTML('<p class="centrado" style="font-size:16.5px">Lic. '.$jref.'</p>');
        $mpdf->WriteHTML('<p class="centrado" style="font-size:16.5px">'.$titulo.' del Registro del Estado Familiar</p>');
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
    //utf8_decode($nombre)
    $mpdf->Output(iconv('UTF-8', 'windows-1252', $nombre),$destino);
    echo $script;
    exit;
  }

  public function actionDefuncion()
  {
    $model = new Defuncion();
    $partidaModelo = new Partida();
    $conexion = \Yii::$app->db;
    $transaccion = $conexion->beginTransaction();
    if($model->load(Yii::$app->request->post()) && $partidaModelo->load(Yii::$app->request->post())){
      require_once('../auxiliar/Auxiliar.php');
      $partidaModelo->cod_empleado = Yii::$app->user->identity->persona->codEmpleado->codigo;
      $partidaModelo->tipo = "Defuncion";
      $model->cod_partida = 0;
      $codlibro = Libro::find()->select('codigo')->where("tipo = 'Defuncion'")->andWhere("anyo = :an",[':an'=>date('Y')])->andWhere('numero = :valor',[':valor'=>$_POST['Partida']['num_libro']])->one()->codigo;
      $partidaModelo->cod_libro = $codlibro;
      if ($model->validate() && $partidaModelo->validate()) {
        try{
          $partidaModelo->fecha_emision = fechaMySQL($partidaModelo->fecha_emision);
          $partidaModelo->fecha_suceso = fechaMySQL($partidaModelo->fecha_suceso);
          $partidaModelo->hora_suceso = horaMySQL($partidaModelo->hora_suceso);
          if($partidaModelo->save()){
            //Recupero el valor de id con el cual se inserto
            $ulid = $conexion->getLastInsertID();
            $model->cod_partida = $ulid;
            //Guardo el registro de defuncion
            if(!$model->save()){
              throw new UserException('No se pudo guardar el registro de defunción, intente nuevamente');
            }
            //Actualizar el folio actual del libro
            if($conexion->createCommand("update libro set folio_actual = folio_actual + 1 where codigo = ".$codlibro)->execute()<=0){
              throw new UserException('No se pudo actualizar el libro de partidas, intente nuevamente');
            }
            //Hay que actualizar el estado de la persona para reflejar que esta inactivo
            if($conexion->createCommand("update persona set estado = 'Inactivo' where codigo = ".$_POST['Defuncion']['cod_difunto'])->execute()<=0){
              throw new UserException('No se pudo actualizar el estado de la persona, intente nuevamente');
            }
            $transaccion->commit();
            Yii::$app->session->setFlash('success', 'Partida guardada con éxito');
            return $this->redirect(['defuncion']);
          }else{
            throw new UserException('No se pudo guardar el registro de partida, intente nuevamente');
          }
          return;
        }catch(UserException $err){
            $transaccion->rollback();
            Yii::$app->session->setFlash('error', $err->getMessage());
            return $this->redirect(['defuncion']);
        }
      }else{
        Yii::$app->session->setFlash('error', 'El modelo no cumple con la validación');
      }
    }
    return $this->render('rdefuncion', ['model'=> $model,'partida'=>$partidaModelo]);
  }

  public function actionMatrimonio()
  {
    $model = new Matrimonio();
    $partidaModelo = new Partida();
    $dbCon = new Persona();
    $conexion = \Yii::$app->db;
    $transaccion = $conexion->beginTransaction();
    if($model->load(Yii::$app->request->post()) && $partidaModelo->load(Yii::$app->request->post())) {
      require_once('../auxiliar/Auxiliar.php');
      $model->cod_partida = 0;
      $partidaModelo->cod_empleado = Yii::$app->user->identity->persona->codEmpleado->codigo;
      $partidaModelo->lugar_suceso = 'Ilopango';
      $partidaModelo->cod_municipio = 151;
      $partidaModelo->tipo = 'Matrimonio';
      $model->est_civ_h = Persona::find()->where('codigo = '.$_POST['MatrimonioPersona']['cod_conhom'])->one()->cod_estado_civil;
      $model->est_civ_m = Persona::find()->where('codigo = '.$_POST['MatrimonioPersona']['cod_conmuj'])->one()->cod_estado_civil;
      $codlibro = Libro::find()->select('codigo')->where("tipo = 'Matrimonio'")->andWhere("anyo = :an",[':an'=>date('Y')])->andWhere('numero = :valor',[':valor'=>$_POST['Partida']['num_libro']])->one()->codigo;
      $partidaModelo->cod_libro = $codlibro;
      //Apellido casada si se establece pero va vacio, tiene sentido porque no lo indico nada, pero que hace que falle la validacion del modelo?
      if($model->validate() && $partidaModelo->validate()){
        try{
          $partidaModelo->fecha_emision = fechaMySQL($partidaModelo->fecha_emision);
          $partidaModelo->fecha_suceso = fechaMySQL($partidaModelo->fecha_suceso);
          $partidaModelo->hora_suceso = horaMySQL($partidaModelo->hora_suceso);
          if($partidaModelo->save()){
            //Recupero el valor de id con el cual se inserto
            $ulid = $conexion->getLastInsertID();
            $model->cod_partida = $ulid;
            //Guardo el registro de matrimonio
            if($model->save()){
              //Recupero el id de matrimonio para luego insertar en matrimonio_persona
              $ulid = $conexion->getLastInsertID();
              //Para MatrimonioPersona
              $modelMph = new MatrimonioPersona();
              $modelMpm = new MatrimonioPersona();
              $modelMph->cod_matrimonio = $ulid;
              $modelMpm->cod_matrimonio = $ulid;
              //Para el contrayente
              $modelMph->cod_persona = $_POST['MatrimonioPersona']['cod_conhom'];
              if(!$modelMph->save()){
                throw new UserException('No se pudo guardar el contrayente, intente nuevamente');
              }
              //Se actualiza el estado civil del contrayente
              $dbCon = Persona::find()->where('codigo = '.$modelMph->cod_persona)->one();
              $dbCon->cod_estado_civil = 2;
              if(!$dbCon->save()){
                throw new UserException('No se pudo actualizar el estado civil del contrayente, intente nuevamente');
              }
              //Para la contrayente
              $modelMpm->cod_persona = $_POST['MatrimonioPersona']['cod_conmuj'];
              if(!$modelMpm->save()){
                throw new UserException('No se pudo guardar la contrayente, intente nuevamente');
              }
              //Se actualiza el estado civil de la contrayente
              $dbCon = Persona::find()->where('codigo = '.$modelMpm->cod_persona)->one();
              $dbCon->cod_estado_civil = 2;
              //Debo guardar el apellido de casada?
              if($_POST['Matrimonio']['apellido_casada']!=''){
                $dbCon->apellido_casada = strtok($dbCon->apellido, " ").' '.$_POST['Matrimonio']['apellido_casada'];
              }
              if(!$dbCon->save()){
                throw new UserException('No se pudo actualizar el estado civil de la contrayente, intente nuevamente');
              }
            }else{
              throw new UserException('No se pudo guardar el registro de matrimonio, intente nuevamente');
            }
            //Actualizar el folio actual del libro
            if($conexion->createCommand("update libro set folio_actual = folio_actual + 1 where codigo = ".$codlibro)->execute()<=0){
              throw new UserException('No se pudo actualizar el libro de partidas, intente nuevamente');
            }
            $transaccion->commit();
            Yii::$app->session->setFlash('success', 'Partida guardada con éxito');
            return $this->redirect(['matrimonio']);
          }else{
            throw new UserException('No se pudo guardar el registro de partida, intente nuevamente');
          }
          return;
        }catch(UserException $err){
            $transaccion->rollback();
            Yii::$app->session->setFlash('error', $err->getMessage());
            return $this->redirect(['matrimonio']);
        }
      }else{
        Yii::$app->session->setFlash('error', 'El modelo no cumple con la validación');
      }
    }
    return $this->render('rmatrimonio', ['model'=> $model,'partida'=>$partidaModelo]);
  }

  public function actionDivorcio()
  {
    $model = new Divorcio();
    $partidaModelo = new Partida();
    $dbCon = new Persona();
    $conexion = \Yii::$app->db;
    $transaccion = $conexion->beginTransaction();
    if($model->load(Yii::$app->request->post()) && $partidaModelo->load(Yii::$app->request->post())){
      require_once('../auxiliar/Auxiliar.php');
      $model->cod_partida = 0;
      $partidaModelo->cod_libro = 1;
      $partidaModelo->cod_empleado = Yii::$app->user->identity->persona->codEmpleado->codigo;
      $partidaModelo->lugar_suceso = $partidaModelo->codMunicipio->nombre;
      $partidaModelo->tipo = 'Divorcio';
      if($model->validate() && $partidaModelo->validate()){
        try{
          $codlibro = Libro::find()->select('codigo')->where("tipo = 'Divorcio'")->andWhere("anyo = :an",[':an'=>date('Y')])->andWhere('numero = :valor',[':valor'=>$_POST['Partida']['num_libro']])->one()->codigo;
          $partidaModelo->cod_libro = $codlibro;
          $partidaModelo->fecha_emision = fechaMySQL($partidaModelo->fecha_emision);
          $partidaModelo->fecha_suceso = fechaMySQL($partidaModelo->fecha_suceso);
          $model->fecha_ejecucion = fechaMySQL($model->fecha_ejecucion);
          $partidaModelo->hora_suceso = horaMySQL($partidaModelo->hora_suceso);
          if($partidaModelo->save()){
            //Recupero el valor de id con el cual se inserto
            $ulid = $conexion->getLastInsertID();
            $model->cod_partida = $ulid;
            //Guardo el registro de divorcio
            if(!$model->save()){
              throw new UserException('No se pudo guardar el registro de divorcio, intente nuevamente');
            }
            $arrper = $model->codMatrimonio->matrimonioPersonas;
            $dbCon = $arrper[0]->codPersona;
            $dbCon->cod_estado_civil = 3;
            //Se actualiza el estado civil de los contrayentes
            if(!$dbCon->save()){
              throw new UserException('No se pudo actualizar el estado civil del contrayente, intente nuevamente');
            }
            $dbCon = $arrper[1]->codPersona;
            $dbCon->cod_estado_civil = 3;
            //Se actualiza el estado civil de los contrayentes
            if(!$dbCon->save()){
              throw new UserException('No se pudo actualizar el estado civil de la contrayente, intente nuevamente');
            }
            //Actualizar el folio actual del libro
            if($conexion->createCommand("update libro set folio_actual = folio_actual + 1 where codigo = ".$codlibro)->execute()<=0){
              throw new UserException('No se pudo actualizar el libro de partidas, intente nuevamente');
            }
            $transaccion->commit();
            Yii::$app->session->setFlash('success', 'Partida guardada con éxito');
            return $this->redirect(['divorcio']);
          }else{
            throw new UserException('No se pudo guardar el registro de partida, intente nuevamente');
          }
          return;
        }catch(UserException $err){
            $transaccion->rollback();
            Yii::$app->session->setFlash('error', $err->getMessage());
            return $this->redirect(['divorcio']);
        }
      }else{
        Yii::$app->session->setFlash('error', 'El modelo no cumple con la validación');
      }
    }
    return $this->render('rdivorcio', ['model'=> $model,'partida'=>$partidaModelo]);
  }
}
