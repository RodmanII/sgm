<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Mantenimientos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-mantenimientos">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
      <?php
        echo Html::dropDownList('opciones',null, $data, ['class'=>'form-control','id'=>'opciones']);
      ?>
    </p>
    <div class="form-group">
      <?= Html::textInput('fmant','',array('id'=>'nrwr1','class'=>'form-control')); ?>
      <span id="matches1" style="display:none"></span>
    </div>
    <button class="btn btn-primary" id="viajar">Ir a mantenimiento</button>
    <script type="text/javascript">
    	viajar.addEventListener('click',function(){
    		window.open("/sgm/web/"+opciones.value);
    	});
    </script>
    <?php
      $this->registerJsFile(Yii::$app->homeUrl."js/fmant.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
    ?>
</div>
