<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Mantenimientos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-mantenimientos">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php
      function capitalizar($texto){
        return str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($texto))));
      }
    ?>
    <p>
        <?php
        echo "<select class='selectpicker' id='opciones'>";
            foreach ($data as $fila) {
              echo "<option value='".$fila['tabla']."'>".capitalizar($fila['tabla'])."</option>";
            }
        echo "</select>";
        ?>
    </p>
    <button class="btn btn-primary" id="viajar">Ir a mantenimiento</button>
    <script type="text/javascript">
      $('.selectpicker').selectpicker();
    </script>
    <script type="text/javascript">
    	viajar.addEventListener('click',function(){
    		window.location.href = "/sgm/web/"+opciones.value;
    	});
    </script>
</div>
