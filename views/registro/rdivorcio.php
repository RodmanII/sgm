<?php

use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\TimePicker;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\mant\Informante;
use app\models\mant\Departamento;
use app\models\mant\Municipio;
use app\models\mant\Divorcio;
use app\models\mant\Matrimonio;
use app\models\mant\ModalidadDivorcio;
use app\models\mant\Libro;
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $model app\models\mant\Nacimiento */
/* @var $form ActiveForm */
$this->title = 'Inscripción de Divorcio';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rdivorcio">
  <?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
      <?= Yii::$app->session->getFlash('success') ?>
    </div>
  <?php endif; ?>

  <?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger">
      <?= Yii::$app->session->getFlash('error') ?>
    </div>
  <?php endif; ?>
  <?php $form = ActiveForm::begin(); ?>
  <?php
  $dbLibro = Libro::find()->where('tipo = "Divorcio"')->andWhere('cerrado = 0')->andWhere('anyo = :valor',[':valor'=>date("Y")])->one();
  $dbDivorcio = Divorcio::find()->orderBy(['codigo'=>SORT_DESC])->limit(1)->one();
  if(count($dbDivorcio)>0){
    $num_partida = $dbDivorcio->codigo+1;
  }else{
    $num_partida = 1;
  }
  $partida->cod_libro = $dbLibro->codigo;
  $partida->folio = $dbLibro->folio_actual + 1;
  ?>
  <div class="cflex">
    <span style="order: 1; flex-grow: 1; margin-right:10px;">
      <div class="form-group">
        <?= Html::label('Libro', 'num_libro'); ?>
        <?= Html::textInput('Partida[num_libro]',$dbLibro->numero,array('id'=>'partida-num_libro', 'class'=>'form-control','readonly'=>'readonly')); ?>
      </div>
    </span>
    <span style="order: 2; flex-grow: 1; margin-right:10px;">
      <?= $form->field($partida, 'folio')->textInput(array('readOnly'=>true)) ?>
    </span>
    <span style="order: 3; flex-grow: 1; margin-right:10px;">
      <?= $form->field($model, 'codigo')->textInput(array('readOnly'=>true,'value'=>$num_partida)) ?>
    </span>
  </div>
  <div class="cflex">
    <span style="order: 1; flex-grow: 1; margin-right:10px;">
      <?= $form->field($model, 'cod_matrimonio')->dropDownList(ArrayHelper::map(Matrimonio::find()->all(), 'codigo', 'codigo')) ?>
      <div class="form-group">
        <?= Html::textInput('fparm','',array('id'=>'nrwr1','class'=>'form-control')); ?>
        <span id="matches1" style="display:none"></span>
      </div>
    </span>
    <span style="order: 2; flex-grow: 1; margin-right:10px;">
      <?= $form->field($model, 'juez')->textArea(array('rows'=>4,'style'=>'resize:none','placeholder'=>'Especifique al juez')) ?>
    </span>
    <span style="order: 3; flex-grow: 1; margin-right:10px;">
      <?= $form->field($model, 'cod_mod_divorcio')->dropDownList(ArrayHelper::map(ModalidadDivorcio::find()->all(), 'codigo', 'nombre')) ?>
    </span>
  </div>
  <div class="cflex">
    <span style="order: 1; flex-grow: 1; margin-right:10px;">
      <div class="form-group">
        <?= Html::label('Departamento', 'depto'); ?>
        <?= Html::dropDownList('deptos',null, ArrayHelper::map(Departamento::find()->all(), 'codigo', 'nombre'), ['id'=>'depto','class'=>'form-control','onchange'=>'
        $.post( "'.Yii::$app->urlManager->createUrl('general/municipios?id=').'"+$(this).val(), function( data ) {
          $( "select#partida-cod_municipio" ).html( data );
        });
        ']) ?>
      </div>
    </span>
    <span style="order: 2; flex-grow: 1; margin-right:10px;">
      <?= $form->field($partida, 'cod_municipio')->dropDownList(ArrayHelper::map(Municipio::find()->where('cod_departamento = 1')->all(), 'codigo', 'nombre')) ?>
    </span>
  </div>
  <div class="cflex">
    <span style="order: 1; flex-grow: 1; margin-right:10px;">
      <?= $form->field($model, 'detalle')->textArea(array('rows'=>4,'style'=>'resize:none','placeholder'=>'Especifique la información adicional')) ?>
    </span>
  </div>
  <div class="cflex">
    <span style="order: 1; flex-grow: 1; margin-right:10px;">
      <?= $form->field($partida, 'fecha_emision')->textInput(array('readOnly'=>true,'value'=>date('d/m/Y'))) ?>
    </span>
    <span style="order: 2; flex-grow: 1; margin-right:10px;">
      <?= $form->field($partida,'fecha_suceso')->widget(DatePicker::className(),[
        'language'=>'es',
        'readonly'=>true,
        'options'=>['placeholder'=>'Especifique la fecha'],
        'pluginOptions'=>['format'=>'dd/mm/yyyy','autoclose'=>true],
        'pluginEvents'=>['hide'=>'function(e) {
          from = $("#partida-fecha_emision").val().split("/");
          fe = new Date(from[2], from[1] - 1, from[0]);
          if(e.date > fe){
            alert("La fecha de divorcio no puede ser posterior a la fecha de emisión de la partida");
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1; //January is 0!
            var yyyy = today.getFullYear();
            dd--;
            if(dd<10) {
              dd="0"+dd
            }
            if(mm<10) {
              mm="0"+mm
            }
            $("#partida-fecha_suceso").val(dd+"/"+mm+"/"+yyyy);
          }
        }'],
        ])->label('Fecha de Divorcio');
        ?>
      </span>
      <span style="order: 3; flex-grow: 1; margin-right:10px;">
        <?= $form->field($partida, 'hora_suceso')->widget(TimePicker::className(), ['language'=>'es', 'pluginOptions'=>[
          'showMeridian'=>true, 'autoclose'=>true], 'options'=>['readonly'=>true]
          ])->label('Hora de Divorcio');
          ?>
        </span>
      </div>
      <div class="cflex">
        <span style="order: 1; flex-grow: 1; margin-right:10px;">
          <?= $form->field($model,'fecha_ejecucion')->widget(DatePicker::className(),[
            'language'=>'es',
            'readonly'=>true,
            'options'=>['placeholder'=>'Especifique la fecha'],
            'pluginOptions'=>['format'=>'dd/mm/yyyy','autoclose'=>true],
            'pluginEvents'=>['hide'=>'function(e) {
              from = $("#partida-fecha_emision").val().split("/");
              fram = $("#partida-fecha_suceso").val().split("/");
              if(fram.length == 1){
                alert("Especifique primero la fecha de divorcio");
                $("#divorcio-fecha_ejecucion").val("");
              }else{
                fe = new Date(from[2], from[1] - 1, from[0]);
                fd = new Date(fram[2], fram[1] - 1, fram[0]);
                var error = true;
                if(e.date < fd){
                  alert("La fecha de ejecución no puede ser anterior a la fecha de divorcio");
                  $("#divorcio-fecha_ejecucion").val("");
                }else{
                  if(e.date > fe){
                    alert("La fecha de ejecución no puede ser posterior a la fecha de emisión de la partida");
                    $("#divorcio-fecha_ejecucion").val("");
                  }
                }
              }
            }'],
            ]);
            ?>
          </span>
        </div>
        <div class="form-group">
          <?= Html::button('Guardar', ['class' => 'btn btn-primary', 'id'=>'guardar']) ?>
          <?= Html::button('Vista Previa', ['class' => 'btn btn-primary', 'id'=>'generar']) ?>
        </div>
        <?php ActiveForm::end(); ?>
        <?php
        $this->registerJsFile(Yii::$app->homeUrl."js/fdivorcio.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
        ?>
      </div>
