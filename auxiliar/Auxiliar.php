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
    list($ano,$mes,$dia) = explode("-",$fechanacimiento);
    $ano_diferencia  = date("Y") - $ano;
    $mes_diferencia = date("m") - $mes;
    $dia_diferencia   = date("d") - $dia;
    if ($dia_diferencia < 0 || $mes_diferencia < 0)
        $ano_diferencia--;
    return $ano_diferencia;
}

function fechaATexto($fecha){
  $obj = new NumeroALetra();
  $meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
  $fechaNac = explode('/',$fecha);
  return trim($obj->to_word($fechaNac[0],null,true,true).' de '.strtolower($meses[$fechaNac[1]]).' del año '.$obj->to_word($fechaNac[2],null,true));
}
?>
