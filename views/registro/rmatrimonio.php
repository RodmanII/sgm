<?php

use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\TimePicker;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\mant\Persona;
use app\models\mant\Informante;
use app\models\mant\Departamento;
use app\models\mant\Municipio;
use app\models\mant\Matrimonio;
use app\models\mant\Libro;
use app\models\mant\MatrimonioPersona;
use app\models\mant\RegimenPatrimonial;
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $model app\models\mant\Nacimiento */
/* @var $form ActiveForm */
$this->title = 'Inscripción de Matrimonio';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rmatrimonio">
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

  <?php $form = ActiveForm::begin(['id'=>'imatrimonio']); ?>
  <?php
  $dbLibro = Libro::find()->where('tipo = "Matrimonio"')->andWhere('cerrado = 0')->andWhere('anyo = :valor',[':valor'=>date("Y")])->one();
  $dbMatrimonio = Matrimonio::find()->orderBy(['codigo'=>SORT_DESC])->limit(1)->one();
  if(count($dbMatrimonio)>0){
    $num_partida = $dbMatrimonio->codigo+1;
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
  <?= Html::hiddenInput('Matrimonio[testigos]','',['id'=>'ites']); ?>
  <div class="cflex">
    <span style="order: 1; flex-grow: 1; margin-right:10px;">
      <?= Html::label('Contrayente Hombre', 'codconhom'); ?>
      <?= Html::dropDownList('MatrimonioPersona[cod_conhom]',null, ArrayHelper::map(Persona::find()->where("genero = 'Masculino'")->andWhere('cod_estado_civil = 1')->all(), 'codigo', 'nombre'), ['class'=>'form-control','id'=>'codconhom']) ?>
      <div class="form-group">
        <?= Html::textInput('fchombre','',array('id'=>'nrwr1','class'=>'form-control')); ?>
        <span id="matches1" style="display:none"></span>
      </div>
      <button type="button" class="btn btn-primary" id="edit-hombre">
        <i class="glyphicon glyphicon-edit"></i>
      </button>
      <button type="button" class="btn btn-primary" id="reload-hombre">
        <i class="glyphicon glyphicon-refresh"></i>
      </button>
    </span>
    <span style="order: 2; flex-grow: 1; margin-right:10px;">
      <?= Html::label('Contrayente Mujer', 'codconmuj'); ?>
      <?= Html::dropDownList('MatrimonioPersona[cod_conmuj]',null, ArrayHelper::map(Persona::find()->where("genero = 'Femenino'")->andWhere('cod_estado_civil = 1')->all(), 'codigo', 'nombre'), ['class'=>'form-control','id'=>'codconmuj']) ?>
      <div class="form-group">
        <?= Html::textInput('fcmujer','',array('id'=>'nrwr1','class'=>'form-control')); ?>
        <span id="matches1" style="display:none"></span>
      </div>
      <button type="button" class="btn btn-primary" id="edit-mujer">
        <i class="glyphicon glyphicon-edit"></i>
      </button>
      <button type="button" class="btn btn-primary" id="reload-mujer">
        <i class="glyphicon glyphicon-refresh"></i>
      </button>
    </span>
  </div>
  <div class="cflex">
    <span style="order: 1; flex-grow: 1; margin-right:10px;">
      <?= $form->field($model, 'notario')->textInput(array('placeholder'=>'Especifique al notario')) ?>
    </span>
    <span style="order: 2; flex-grow: 1; margin-right:10px;">
      <?= $form->field($model, 'cod_reg_patrimonial')->dropDownList(ArrayHelper::map(RegimenPatrimonial::find()->all(), 'codigo', 'nombre')) ?>
    </span>
  </div>
  <div class="cflex">
    <table id="ttestigos" class="table table-striped table-bordered tablac">
      <caption>
        Testigos
      </caption>
      <thead>
        <th>Nombre</th>
        <th></th>
      </thead>
      <tbody></tbody>
    </table>
  </div>
  <div class="cflex">
    <span style="order: 1; flex-grow: 1; margin-right:10px;">
      <?= $form->field($model, 'padre_contrayente_h')->textInput(array('placeholder'=>'Especifique al padre')) ?>
    </span>
    <span style="order: 2; flex-grow: 1; margin-right:10px;">
      <?= $form->field($model, 'madre_contrayente_h')->textInput(array('placeholder'=>'Especifique a la madre')) ?>
    </span>
  </div>
  <div class="cflex">
    <span style="order: 1; flex-grow: 1; margin-right:10px;">
      <?= $form->field($model, 'padre_contrayente_m')->textInput(array('placeholder'=>'Especifique al padre')) ?>
    </span>
    <span style="order: 2; flex-grow: 1; margin-right:10px;">
      <?= $form->field($model, 'madre_contrayente_m')->textInput(array('placeholder'=>'Especifique a la madre')) ?>
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
    <span style="order: 3; flex-grow: 1; margin-right:10px;">
      <?= $form->field($partida, 'lugar_suceso')->textInput(array('placeholder'=>'Especifique el lugar'))->label('Lugar de Matrimonio') ?>
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
            alert("La fecha de matrimonio no puede ser posterior a la fecha de emisión de la partida");
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
        ])->label('Fecha de Matrimonio');
        ?>
      </span>
      <span style="order: 3; flex-grow: 1; margin-right:10px;">
        <?= $form->field($partida, 'hora_suceso')->widget(TimePicker::className(), ['language'=>'es', 'pluginOptions'=>[
          'showMeridian'=>true, 'autoclose'=>true], 'options'=>['readonly'=>true]
          ])->label('Hora de Defunción');
          ?>
        </span>
      </div>

      <div class="form-group">
        <?= Html::button('Guardar', ['class' => 'btn btn-primary', 'id'=>'guardar']) ?>
        <?= Html::button('Vista Previa', ['class' => 'btn btn-primary', 'id'=>'generar']) ?>
      </div>
      <?php ActiveForm::end(); ?>
      <?php
      $this->registerJsFile(Yii::$app->homeUrl."js/fdefuncion.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
      ?>
    </div><!-- rnacimiento -->
