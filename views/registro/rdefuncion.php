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
use app\models\mant\Hospital;
use app\models\mant\Defuncion;
use app\models\mant\CausaDefuncion;
use app\models\mant\Libro;
use yii\db\Query;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\mant\Defuncion */
/* @var $form ActiveForm */
$this->title = 'Inscripción de Defunción';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rdefuncion">
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

  <?php $form = ActiveForm::begin(['id'=>'idefuncion']); ?>
  <?php
    $dbLibro = Libro::find()->where('tipo = "Defuncion"')->andWhere('cerrado = 0')->andWhere('anyo = :valor',[':valor'=>date("Y")])->one();
    $dbDefuncion = Defuncion::find()->orderBy(['codigo'=>SORT_DESC])->limit(1)->one();
    if(count($dbDefuncion)>0){
        $num_partida = $dbDefuncion->codigo+1;
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
  <?= Html::hiddenInput('Defuncion[familiares]','',['id'=>'ifam']); ?>
  <div class="cflex">
    <span style="order: 1; flex-grow: 1; margin-right:10px;">
      <?php
        $query = new Query;
        $query->select(['p.codigo','nombre_completo'=>'CONCAT(p.nombre, " ", p.apellido)'])
          ->from('persona p')->where('p.estado = "Activo"')->where('p.codigo NOT IN (SELECT cod_difunto FROM defuncion)')->orderBy(['p.nombre'=>SORT_ASC]);
        $command = $query->createCommand();
        $data = $command->queryAll();
      ?>
      <?= $form->field($model, 'cod_difunto')->dropDownList(ArrayHelper::map($data, 'codigo', 'nombre_completo')) ?>
      <div class="form-group">
        <?= Html::textInput('fdifunto','',array('id'=>'nrwr1','class'=>'form-control')); ?>
        <span id="matches1" style="display:none"></span>
      </div>
      <button type="button" class="btn btn-primary" id="edit-difunto">
        <i class="glyphicon glyphicon-edit"></i>
      </button>
      <button type="button" class="btn btn-primary" id="reload-difunto">
        <i class="glyphicon glyphicon-refresh"></i>
      </button>
    </span>
      <span style="order: 1; flex-grow: 1; margin-right:10px;">
        <?= $form->field($model, 'cod_causa')->dropDownList(ArrayHelper::map(CausaDefuncion::find()->all(), 'codigo', 'nombre')) ?>
        <div class="form-group">
          <?= Html::textInput('fcausa','',array('id'=>'nrwr2','class'=>'form-control')); ?>
          <span id="matches2" style="display:none"></span>
        </div>
        <button type="button" class="btn btn-primary" id="edit-causa">
          <i class="glyphicon glyphicon-edit"></i>
        </button>
        <button type="button" class="btn btn-primary" id="reload-causa">
          <i class="glyphicon glyphicon-refresh"></i>
        </button>
      </span>
      <span style="order: 2; flex-grow: 1; margin-right:10px;">
        <?= $form->field($model, 'determino_causa')->textArea(array('rows'=>3,'style'=>'resize:none;')) ?>
      </span>
    </div>
    <div class="cflex">
      <table id="tfamiliares" class="table table-striped table-bordered tablac">
        <caption>
          Familiares
        </caption>
        <thead>
          <th>Nombre</th>
          <th>Relación</th>
          <th></th>
        </thead>
        <tbody></tbody>
      </table>
    </div>
    <div class="cflex">
      <span style="order: 1; flex-grow: 1; margin-right:10px;">
        <div class="form-group">
          <?= Html::textInput('nombre_familiar',null,array('id'=>'nomfamiliar', 'class'=>'form-control','placeholder'=>'Nombre del familiar')); ?>
        </div>
      </span>
      <span style="order: 2; flex-grow: 1; margin-right:10px;">
        <div class="form-group">
          <?= Html::radioList('gen_familiar','Masculino',array('Masculino'=>'Masculino','Femenino'=>'Femenino')) ?>
        </div>
      </span>
      <span style="order: 2; flex-grow: 1; margin-right:10px;">
        <div class="form-group">
          <?= Html::dropDownList('rel_familiar','dre', ['dre'=>'Padre-Madre','Herman'=>'Herman@','Ti'=>'Ti@','Espos'=>'Espos@','Abuel'=>'Abuel@'], ['class'=>'form-control','id'=>'relfamiliar']) ?>
        </div>
      </span>
      <span style="order: 4; flex-grow: 1; margin-right:10px;">
        <button id='agfamiliar' type="button" class="btn btn-primary" id="edit-informante" style="margin-top:5px;">
          <i class="glyphicon glyphicon-plus"></i>
        </button>
      </span>
    </div>
    <div class="cflex">
      <span style="order: 1; flex-grow: 1; margin-right:10px;">
        <?= $form->field($partida, 'cod_informante')->dropDownList(ArrayHelper::map(Informante::find()->orderBy(['nombre'=>SORT_ASC])->all(), 'codigo', 'nombre')) ?>
        <div class="form-group">
          <?= Html::textInput('finformante','',array('id'=>'nrwr3','class'=>'form-control')); ?>
          <span id="matches3" style="display:none"></span>
        </div>
        <button type="button" class="btn btn-primary" id="edit-informante">
          <i class="glyphicon glyphicon-edit"></i>
        </button>
        <button type="button" class="btn btn-primary" id="reload-informante">
          <i class="glyphicon glyphicon-refresh"></i>
        </button>
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
        <?= $form->field($partida, 'lugar_suceso')->textInput(array('placeholder'=>'Especifique el lugar'))->label('Lugar de Defuncion') ?>
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
                        alert("La fecha de defunción no puede ser posterior a la fecha de emisión de la partida");
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
                    ])->label('Fecha de Defunción');
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
</div><!-- rdefuncion -->
