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
use app\models\mant\Libro;
use app\models\mant\Nacimiento;
use yii\db\Query;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\mant\Nacimiento */
/* @var $form ActiveForm */
$this->title = 'Inscripción de Nacimiento';
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

    <?php $form = ActiveForm::begin(['id'=>'inacimiento']); ?>
    <?php
      $dbLibro = Libro::find()->where('tipo = "Nacimiento"')->andWhere('cerrado = 0')->andWhere('anyo = :valor',[':valor'=>date("Y")])->one();
      $dbNacimiento = Nacimiento::find()->orderBy(['codigo'=>SORT_DESC])->limit(1)->one();
      if(count($dbNacimiento)>0){
          $num_partida = $dbNacimiento->codigo+1;
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
        <?php
          $query = new Query;
          $query->select(['p.codigo','nombre_completo'=>'CONCAT(p.nombre, " ", p.apellido)'])
            ->from('persona p')->where('p.estado = "Activo"')->andWhere('calcularEdad(p.codigo) < 1')->andWhere('p.codigo NOT IN (SELECT cod_asentado FROM nacimiento)')->orderBy(['p.nombre'=>SORT_ASC]);
          $command = $query->createCommand();
          $data = $command->queryAll();
        ?>
        <?= $form->field($model, 'cod_asentado')->dropDownList(ArrayHelper::map($data, 'codigo', 'nombre_completo')) ?>
        <div class="form-group">
          <?= Html::textInput('fasentado','',array('id'=>'nrwr1','class'=>'form-control')); ?>
          <span id="matches1" style="display:none"></span>
        </div>
        <button type="button" class="btn btn-primary" id="edit-asentado">
          <i class="glyphicon glyphicon-edit"></i>
        </button>
        <button type="button" class="btn btn-primary" id="reload-asentado">
          <i class="glyphicon glyphicon-refresh"></i>
        </button>
      </span>
      <span style="order: 2; flex-grow: 1; margin-right:10px;">
        <?= $form->field($model, 'cod_madre')->dropDownList(ArrayHelper::map(Persona::find()->where('genero = "Femenino"')->andWhere('estado = "Activo"')->andWhere('calcularEdad(persona.codigo) > 14')->orderBy(['nombre'=>SORT_ASC])->all(), 'codigo',
          function($model, $defaultValue) {
            return $model->nombre.' '.$model->apellido;
          }
        ), ['prompt'=>'Ninguna']) ?>
        <div class="form-group">
          <?= Html::textInput('fmadre','',array('id'=>'nrwr','class'=>'form-control')); ?>
          <span id="matches" style="display:none"></span>
        </div>
        <button type="button" class="btn btn-primary" id="edit-madre">
          <i class="glyphicon glyphicon-edit"></i>
        </button>
        <button type="button" class="btn btn-primary" id="reload-madre">
          <i class="glyphicon glyphicon-refresh"></i>
        </button>
      </span>
      <span style="order: 3; flex-grow: 1; margin-right:10px;">
        <?= $form->field($model, 'cod_padre')->dropDownList(ArrayHelper::map(Persona::find()->where('genero = "Masculino"')->andWhere('estado = "Activo"')->andWhere('calcularEdad(persona.codigo) > 14')->orderBy(['nombre'=>SORT_ASC])->all(), 'codigo',
          function($model, $defaultValue) {
            return $model->nombre.' '.$model->apellido;
          }
        ), ['prompt'=>'Ninguno']) ?>
        <div class="form-group">
          <?= Html::textInput('fpadre','',array('id'=>'nrwr2','class'=>'form-control')); ?>
          <span id="matches2" style="display:none"></span>
        </div>
        <button type="button" class="btn btn-primary" id="edit-padre">
          <i class="glyphicon glyphicon-edit"></i>
        </button>
        <button type="button" class="btn btn-primary" id="reload-padre">
          <i class="glyphicon glyphicon-refresh"></i>
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
      <span style="order: 2; flex-grow: 1; margin-right:10px;">
        <?= $form->field($model, 'rel_informante')->dropDownList(['Padre'=>'Padre','Madre'=>'Madre','Tio'=>'Tio','Tia'=>'Tia','Abuelo'=>'Abuelo','Abuela'=>'Abuela']); ?>
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
        <?= $form->field($partida, 'lugar_suceso')->textInput(array('placeholder'=>'Especifique el lugar'))->label('Lugar de Nacimiento') ?>
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
                        alert("La fecha de nacimiento no puede ser posterior a la fecha de emisión de la partida");
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
                    ])->label('Fecha de Nacimiento');
                ?>
      </span>
      <span style="order: 3; flex-grow: 1; margin-right:10px;">
        <?= $form->field($partida, 'hora_suceso')->widget(TimePicker::className(), ['language'=>'es', 'pluginOptions'=>[
            'showMeridian'=>true, 'autoclose'=>true], 'options'=>['readonly'=>true]
            ])->label('Hora de Nacimiento');
        ?>
      </span>
    </div>
    <div class="cflex">
      <span style="order: 1; flex-grow: 1; margin-right:10px;">
        <?= $form->field($model, 'cod_hospital')->dropDownList(ArrayHelper::map(Hospital::find()->all(), 'codigo', 'nombre')) ?>
        <div class="form-group">
          <?= Html::textInput('fhospital','',array('id'=>'nrwr4','class'=>'form-control')); ?>
          <span id="matches4" style="display:none"></span>
        </div>
        <button type="button" class="btn btn-primary" id="edit-hospital">
          <i class="glyphicon glyphicon-edit"></i>
        </button>
        <button type="button" class="btn btn-primary" id="reload-hospital">
          <i class="glyphicon glyphicon-refresh"></i>
        </button>
      </span>
    </div>
    <div class="form-group">
        <?= Html::button('Guardar', ['class' => 'btn btn-primary', 'id'=>'guardar']) ?>
        <?= Html::button('Vista Previa', ['class' => 'btn btn-primary', 'id'=>'generar']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <?php
      $this->registerJsFile(Yii::$app->homeUrl."js/fnacimiento.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
    ?>
</div>
