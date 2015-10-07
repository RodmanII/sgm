<?php
use app\auxiliar\NumeroALetra;
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
?>
