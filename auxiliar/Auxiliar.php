<?php
use app\auxiliar\NumeroALetra;
use app\models\mant\Municipio;
use app\models\mant\Nacionalidad;
use app\models\mant\Persona;
use app\models\mant\EstadoCivil;
use yii\db\Query;

function fechaMySQL($fecha){
  $formateado = str_replace('/', '-', $fecha);
  return date('Y-m-d', strtotime($formateado));
}

function convertirBool($valor){
  if($valor == false){
    return 'No';
  }else{
    return 'Si';
  }
}

function horaMySQL($hora){
  $formateado = DateTime::createFromFormat( 'H:i A', $hora);
  return $formateado->format( 'H:i:s');
}

function obtenerParams($parametros){
  $auxiliar = explode(';',$parametros);
  $param = array();
  foreach($auxiliar as $elemento){
    $aux = explode('*',$elemento);
    $param[$aux[0]] = $aux[1];
  }
  return $param;
}

function calcularEdad($fechanacimiento){
    list($Y,$m,$d) = explode("-",$fechanacimiento);
    return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
}

function fechaATexto($fecha){
  $obj = new NumeroALetra();
  $meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
  $fechaNac = explode('/',$fecha);
  $mes = str_split($fechaNac[1]);
  $mesIndicador = $mes[0].$mes[1];
  if($mes[0]=='0'){
    $mesIndicador = $mes[1];
  }
  return trim($obj->to_word($fechaNac[0],null,true,true).' de '.strtolower($meses[$mesIndicador]).' del año '.$obj->to_word($fechaNac[2],null,true));
}

function fechaComun($fecha){
  $d = DateTime::createFromFormat('Y-m-d', $fecha);
  if($d && $d->format('Y-m-d') == $fecha){
    return date_format(date_create_from_format('Y-m-d', $fecha), 'd/m/Y');
  }else{
    return $fecha;
  }
}

function retornarDato($model, $tipo, $origen = false){
  if($tipo == 'Municipio'){
    $val = $model->cod_municipio;
    if($origen){
      $val = $model->cod_mun_origen;
    }
    $objMunicipio = Municipio::find()->where('codigo = :valor', [':valor'=>$val])->one();
    return $objMunicipio->nombre;
  }else if($tipo == 'Nacionalidad'){
    $objNacionalidad = Nacionalidad::find()->where('codigo = :valor', [':valor'=>$model->cod_nacionalidad])->one();
    return $objNacionalidad->nombre;
  }else if($tipo == 'EstadoCivil'){
    $objEstCivil = EstadoCivil::find()->where('codigo = :valor', [':valor'=>$model->cod_estado_civil])->one();
    return $objEstCivil->nombre;
  }else if($tipo == 'Persona'){
    if($model->cod_persona!=null || $model->cod_persona!=''){
      $query = new Query;
      $query->select(['p.codigo','nombre_completo'=>'CONCAT(p.nombre, " ", p.apellido)'])
        ->from('persona p')->where('p.codigo = :valor', [':valor'=>$model->cod_persona]);
      $command = $query->createCommand();
      $data = $command->queryOne();
      return $data['nombre_completo'];
    }else{
      return null;
    }
  }else{
    return null;
  }
}
?>
