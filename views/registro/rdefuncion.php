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
use app\models\mant\CausaDefuncion;
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $model app\models\mant\Nacimiento */
/* @var $form ActiveForm */
$this->title = 'Inscripción de Defunción';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rdefuncion">
    <?php $form = ActiveForm::begin(); ?>
    <div class="cflex">
      <span style="order: 1; flex-grow: 1; margin-right:10px;">
        <?= $form->field($partida, 'cod_libro')->textInput(array('readOnly'=>true,'value'=>4)) ?>
      </span>
      <span style="order: 2; flex-grow: 1; margin-right:10px;">
        <?= $form->field($partida, 'folio')->textInput(array('readOnly'=>true,'value'=>17)) ?>
      </span>
      <span style="order: 3; flex-grow: 1; margin-right:10px;">
        <?= $form->field($partida, 'numero')->textInput(array('readOnly'=>true,'value'=>19)) ?>
      </span>
    </div>
    <div class="cflex">
      <span style="order: 1; flex-grow: 1; margin-right:10px;">
        <?= $form->field($model, 'cod_difunto')->dropDownList(ArrayHelper::map(Persona::find()->all(), 'codigo', 'nombre'), ['prompt'=>'Especifique al difunto']) ?>
        <button type="submit" class="btn btn-primary">
          <i class="glyphicon glyphicon-edit"></i>
        </button>
        <button type="submit" class="btn btn-primary">
          <i class="glyphicon glyphicon-search"></i>
        </button>
      </span>
      <span style="order: 1; flex-grow: 1; margin-right:10px;">
        <?= $form->field($model, 'cod_causa')->dropDownList(ArrayHelper::map(CausaDefuncion::find()->all(), 'codigo', 'nombre'), ['prompt'=>'Especifique la causa']) ?>
        <button type="submit" class="btn btn-primary">
          <i class="glyphicon glyphicon-edit"></i>
        </button>
        <button type="submit" class="btn btn-primary">
          <i class="glyphicon glyphicon-search"></i>
        </button>
      </span>
      <span style="order: 2; flex-grow: 1; margin-right:10px;">
        <?= $form->field($model, 'determino_causa')->textArea(array('rows'=>3,'style'=>'resize:none;')) ?>
      </span>
    </div>
    <?php
      $proveedor = [
      array("nombre"=>"Ernesto Javier Calvo Fuentes","relacion"=>"Padre"),
      array("nombre"=>"Georgina Maribel Valle de Fuentes","relacion"=>"Madre"),
      array("nombre"=>"Mónica Roxana Beltrán Cruz","relacion"=>"Esposa"),
      ];

      $dataProvider = new ArrayDataProvider([
          'key'=>'nombre',
          'allModels' => $proveedor,
          'sort' => [
              'attributes' => ['nombre', 'relacion'],
          ],
      ]);
      $isFa = true;
      echo GridView::widget([
      'dataProvider'=>$dataProvider,
      'columns'=>[
          ['class'=>'yii\grid\SerialColumn'],
          [
              'attribute'=>'nombre',
              'value'=>'nombre',
          ],
          [
              'attribute'=>'relacion',
              'value'=>'relacion',
          ],
          [
              'class' => 'yii\grid\ActionColumn',
              'header'=>'Acciones',
              'template' => '{update} {delete}',
          ]
      ],
      'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
      'headerRowOptions'=>['class'=>'kartik-sheet-style'],
      'filterRowOptions'=>['class'=>'kartik-sheet-style'],
      'pjax'=>true, // pjax is set to always true for this demo
      // set your toolbar
      'beforeHeader'=>[
          [
              'options'=>['class'=>'skip-export'] // remove this row from export
          ]
      ],
      'toolbar'=> [
          ['content'=>
              Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>'Agregar familiar', 'class'=>'btn btn-success', 'onclick'=>'alert("Esto lanzara la interfaz de adición de familiares");']) . ' '.
              Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['grid-demo'], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>'Limpiar'])
          ],
      ],
      // set export properties
      'export'=>false,
      // parameters from the demo form
      'bordered'=>true,
      'striped'=>false,
      'condensed'=>false,
      'responsive'=>true,
      'hover'=>true,
      'showPageSummary'=>false,
      'panel'=>[
          'type'=>GridView::TYPE_PRIMARY,
          'heading'=>"Familiares",
      ],
      'persistResize'=>false,
      ]);
    ?>
    <div class="cflex">
      <span style="order: 1; flex-grow: 1; margin-right:10px;">
        <?= $form->field($partida, 'cod_informante')->dropDownList(ArrayHelper::map(Informante::find()->all(), 'codigo', 'nombre'), ['prompt'=>'Especifique al informante']) ?>
        <button type="submit" class="btn btn-primary">
          <i class="glyphicon glyphicon-edit"></i>
        </button>
        <button type="submit" class="btn btn-primary">
          <i class="glyphicon glyphicon-search"></i>
        </button>
      </span>
    </div>
    <div class="cflex">
      <span style="order: 1; flex-grow: 1; margin-right:10px;">
        <?= $form->field($partida, 'cod_municipio')->dropDownList(ArrayHelper::map(Departamento::find()->all(), 'codigo', 'nombre'), ['prompt'=>'Especifique el departamento'])->label('Departamento') ?>
      </span>
      <span style="order: 2; flex-grow: 1; margin-right:10px;">
        <?= $form->field($partida, 'cod_municipio')->dropDownList(ArrayHelper::map(Municipio::find()->all(), 'codigo', 'nombre'), ['prompt'=>'Especifique el municipio']) ?>
      </span>
    </div>
    <div class="cflex">
      <span style="order: 3; flex-grow: 1; margin-right:10px;">
        <?= $form->field($partida, 'lugar_suceso')->textInput(array('placeholder'=>'Especifique el lugar'))->label('Lugar de Defunción') ?>
        <button type="submit" class="btn btn-primary">
          <i class="glyphicon glyphicon-search"></i> Hospital
        </button>
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
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Vista Previa', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- rnacimiento -->
