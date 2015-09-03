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
        echo "<select class='selectpicker' id='mant'>";
            foreach ($data as $fila) {
              echo "<option value='".$fila['tabla']."'>".capitalizar($fila['tabla'])."</option>";
            }
        echo "</select>";
        ?>
    </p>
    <button class="btn btn-primary">Ir a mantenimiento</button>
    <script type="text/javascript">
      $('.selectpicker').selectpicker();
    </script>

</div>
