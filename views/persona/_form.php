<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use kartik\widgets\DatePicker;
use app\models\mant\Departamento;
use app\models\mant\Municipio;
use app\models\mant\Nacionalidad;
use app\models\mant\EstadoCivil;
use app\models\mant\Usuario;
use app\models\mant\Informante;
use yii\helpers\ArrayHelper;
use yii\web\View;

?>

<div class="persona-form">

  <?php if (Yii::$app->session->hasFlash('error')): ?>
  <div class="alert alert-danger">
    <?= Yii::$app->session->getFlash('error') ?>
  </div>
  <?php endif; ?>

  <?php $form = ActiveForm::begin(['options'=>['id'=>'personafrm']]); ?>

  <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

  <?= $form->field($model, 'apellido')->textInput(['maxlength' => true]) ?>

  <?php
    if($model->genero == 'Femenino'){
      echo $form->field($model, 'apellido_casada')->textInput(['maxlength' => true]);
    }else{
      echo $form->field($model, 'apellido_casada')->textInput(['maxlength' => true, 'readonly'=>true]);
    }
  ?>

  <?= $form->field($model, 'dui')->textInput(['maxlength' => true]) ?>

  <?= $form->field($model, 'nit')->textInput(['maxlength' => true]) ?>

  <?php
    if(!$model->isNewRecord){
      require_once('../auxiliar/Auxiliar.php');
      if(!empty($model->fecha_nacimiento)){
        $model->fecha_nacimiento = fechaComun($model->fecha_nacimiento);
      }
    }
    echo $form->field($model, 'fecha_nacimiento')->widget(DatePicker::className(),[
    'language'=>'es',
    'readonly'=>true,
    'options'=>['placeholder'=>'Especifique la fecha'],
    'pluginOptions'=>['format'=>'dd/mm/yyyy','autoclose'=>true],
    ]);
  ?>
    <div class="cflex">
      <span style="order: 1; flex-grow: 1; margin-right:10px;">
        <?php
          if($model->isNewRecord){
            $model->genero = 'Masculino';
          }
          ?>
        <?= $form->field($model, 'genero')->radioList(array('Masculino'=>'Masculino','Femenino'=>'Femenino')) ?>
      </span>
      <span style="order: 2; flex-grow: 1; margin-right:10px;">
        <?php
          if($model->isNewRecord){
            $model->empleado = 1;
          }
          ?>
        <?= $form->field($model, 'empleado')->radioList(array(1=>'Empleado',0=>'Desempleado')) ?>
      </span>
    </div>

    <div class="cflex">
      <span style="order: 1; flex-grow: 1; margin-right:10px;">
        <div class="form-group">
          <?= Html::label('Departamento', 'depto'); ?>
          <?= Html::dropDownList('departamento', null, ArrayHelper::map(Departamento::find()->all(), 'codigo', 'nombre'), ['id'=>'depto','class'=>'form-control','onchange'=>'
          $.post( "'.Yii::$app->urlManager->createUrl('general/municipios?id=').'"+$(this).val(), function( data ) {
            $("select#munic").html(data);
            $("#munic").val('.$model->cod_municipio.');
          });
          ']) ?>
        </div>
      </span>
      <span style="order: 2; flex-grow: 1; margin-right:10px;">
        <?php
          if(!$model->isNewRecord){
            $objMunicipio = Municipio::find()->where('codigo = :valor',[':valor'=>$model->cod_municipio])->one();
            $this->registerJs('$("#depto").val('.$objMunicipio->codDepartamento->codigo.').change();',View::POS_READY);
          }
        ?>
        <?= $form->field($model, 'cod_municipio')->dropDownList(ArrayHelper::map(Municipio::find()->where('cod_departamento = 1')->all(), 'codigo', 'nombre'), ['id'=>'munic', 'onblur'=>'
        var direccion = $("#munic option:selected").text() + ", Departamento de "+$("#depto option:selected").text();
        $("#persona-direccion").val(direccion);
        ']) ?>
      </span>
    </div>

    <?= $form->field($model, 'direccion')->textInput(['readonly'=>true,'maxlength' => true]) ?>

    <div class="cflex">
      <span style="order: 1; flex-grow: 1; margin-right:10px;">
        <div class="form-group">
          <?= Html::label('Departamento de Origen', 'deptomo'); ?>
          <?= Html::dropDownList('departamento', null, ArrayHelper::map(Departamento::find()->all(), 'codigo', 'nombre'), ['id'=>'deptomo','class'=>'form-control','onchange'=>'
          $.post( "'.Yii::$app->urlManager->createUrl('general/municipios?id=').'"+$(this).val(), function( data ) {
            $("select#munico").html(data);
            $("#munico").val('.$model->cod_municipio.');
          });
          ']) ?>
        </div>
      </span>
      <span style="order: 2; flex-grow: 1; margin-right:10px;">
        <?php
          if(!$model->isNewRecord){
            $objMunicipio = Municipio::find()->where('codigo = :valor',[':valor'=>$model->cod_mun_origen])->one();
            $this->registerJs('$("#deptomo").val('.$objMunicipio->codDepartamento->codigo.').change();',View::POS_READY);
          }
        ?>
        <?= $form->field($model, 'cod_mun_origen')->dropDownList(ArrayHelper::map(Municipio::find()->where('cod_departamento = 1')->all(), 'codigo', 'nombre'), ['id'=>'munico']) ?>
      </span>
    </div>

    <?= $form->field($model, 'profesion')->textInput(['maxlength' => true]) ?>

    <?php
      /*Antes debo verificar si esta o no inicializado, esto dependera de si se inserta o actualiza y
      he de inicializar segun corresponde*/
      if($model->isNewRecord){
        $model->estado = 'Activo';
      }else{
        echo $form->field($model, 'estado')->radioList(array('Activo'=>'Activo','Inactivo'=>'Inactivo'));
      }
    ?>

    <?= $form->field($model, 'cod_nacionalidad')->dropDownList(ArrayHelper::map(Nacionalidad::find()->all(), 'codigo', 'nombre')) ?>

    <?= $form->field($model, 'cod_estado_civil')->dropDownList(ArrayHelper::map(EstadoCivil::find()->all(), 'codigo', 'nombre')) ?>

    <?php
      if($model->isNewRecord){
        echo $form->field($model, 'nombre_usuario')->dropDownList(ArrayHelper::map(Usuario::find()->where('NOT EXISTS
        (
        SELECT  nombre_usuario
        FROM    persona
        WHERE   persona.nombre_usuario = usuario.nombre
        )')->all(), 'nombre', 'nombre'), ['prompt'=>'Seleccione un usuario']);
      }else{
        echo $form->field($model, 'nombre_usuario')->dropDownList(ArrayHelper::map(Usuario::find()->all(), 'nombre', 'nombre'), ['prompt'=>'Seleccione un usuario']);
      }
    ?>

    <div class="cflex">
        <?php
          $tipodoc = '';
          $numdoc = '';
          if(!$model->isNewRecord){
            if(!empty($model->otro_doc)){
              $arreglo = explode(':',$model->otro_doc);
              $tipodoc = $arreglo[0];
              $numdoc = $arreglo[1];
            }
          }
          echo '<span style="order: 1; flex-grow: 1; margin-right:10px;">';
          echo Html::label('Documento Alternativo', 'nomdoca');
          echo Html::textInput('nomda',$tipodoc,['id'=>'nomdoca', 'class'=>'form-control']);
          echo '</span>';
          echo '<span style="order: 2; flex-grow: 1; margin-right:10px;">';
          echo Html::label('Número Doc. Alternativo', 'numdoca');
          echo Html::textInput('numda',$numdoc,['id'=>'numdoca', 'class'=>'form-control']);
          echo '</span>';
        ?>
      </div>
    </div>

    <?php
        echo '<div class="cflex">';
        echo '<span style="order: 1; flex-grow: 1; margin-right:10px;">';
        if($model->isNewRecord){
          echo Html::label('Es Informante', 'esinfor');
          echo Html::radioList('informante','No',['Si'=>'Si','No'=>'No'],['id'=>'esinfor']);
          echo Html::label('Firma','firin');
          echo Html::fileInput('firma',null,['prompt'=>'Especifique el archivo de imagen con la firma','id'=>'firin','enable'=>false]);
        }else{
          $objInformante = Informante::find()->select('codigo')->where('cod_persona = :valor',[':valor'=>$model->codigo])->one();
          if(isset($objInformante)){
            echo Html::a('Ver informante', '/sgm/web/informante/update/'.$objInformante->codigo, ['target'=>'_blank']);
          }
        }
        echo '</span>';
        echo '</div>';
    ?>

    <div class="form-group">
      <?= Html::button($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','id'=>'procesar']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php
      $this->registerCssFile(Yii::$app->homeUrl."css/custom.css");
      $this->registerCssFile(Yii::$app->homeUrl."css/bootstrap-select.css");
      $this->registerJsFile(Yii::$app->homeUrl."js/bootstrap-select.min.js");
    ?>
  </div>
  <?php
    $this->registerJsFile(Yii::$app->homeUrl."js/mant/fpersona.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
  ?>
