<?php
use app\auxiliar\NumeroALetra;
use app\models\mant\Municipio;
use app\models\mant\Nacionalidad;
use app\models\mant\EstadoCivil;

function fechaMySQL($fecha){
  $formateado = str_replace('/', '-', $fecha);
  return date('Y-m-d', strtotime($formateado));
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

function retornarDato($model, $tipo){
  if($tipo == 'Municipio'){
    $objMunicipio = Municipio::find()->where('codigo = :valor', [':valor'=>$model->cod_municipio])->one();
    return $objMunicipio->nombre;
  }else if($tipo == 'Nacionalidad'){
    $objNacionalidad = Nacionalidad::find()->where('codigo = :valor', [':valor'=>$model->cod_nacionalidad])->one();
    return $objNacionalidad->nombre;
  }else if($tipo == 'EstadoCivil'){
    $objEstCivil = EstadoCivil::find()->where('codigo = :valor', [':valor'=>$model->cod_estado_civil])->one();
    return $objEstCivil->nombre;
  }else{
    return null;
  }
}
?>
