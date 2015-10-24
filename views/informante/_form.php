<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\db\Query;
use app\models\mant\Persona;
use app\models\mant\TipoDocIdentidad;
use yii\helpers\ArrayHelper;

?>

<div class="informante-form">
    <?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger">
      <?= Yii::$app->session->getFlash('error') ?>
    </div>
    <?php endif; ?>

    <?php $form = ActiveForm::begin(['options'=>['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo_documento')->dropDownList(ArrayHelper::map(TipoDocIdentidad::find()->all(), 'nombre', 'nombre')) ?>

    <?= $form->field($model, 'numero_documento')->textInput(['maxlength' => true]) ?>

    <?php
      if($model->isNewRecord){
        $model->genero = 'Masculino';
      }
    ?>
    <?= $form->field($model, 'genero')->radioList(array('Masculino'=>'Masculino','Femenino'=>'Femenino')) ?>

    <?php
      $query = new Query;
      $query->select(['p.codigo','nombre_completo'=>'CONCAT(p.nombre, " ", p.apellido)'])
        ->from('persona p')->where('p.estado = "Activo"')->andWhere('calcularEdad(p.codigo) >= 14')->orderBy(['p.nombre'=>SORT_ASC]);
      $command = $query->createCommand();
      $data = $command->queryAll();
    ?>
    <?php
      if($model->isNewRecord){
        $this->registerJsFile(Yii::$app->homeUrl."js/mant/finformante.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
      }
    ?>
    <?= $form->field($model, 'cod_persona')->dropDownList(ArrayHelper::map($data, 'codigo', 'nombre_completo'),['id'=>'selpersona','prompt'=>'Especifique a la persona asociada']) ?>
    <?php
    if($model->isNewRecord){
      echo "<div class='form-group'>";
      echo Html::textInput('fpersona','',array('id'=>'nrwr1','class'=>'form-control'));
      echo "<span id='matches1' style='display:none'></span>";
      echo "</div>";
    }
    ?>

    <?php
      echo $form->field($model, 'firma')->fileInput(['id'=>'firin','class'=>'form-control']);
    ?>
    <?php
    if(!$model->isNewRecord){
      echo Html::textInput('firmav',$model->firma,['class'=>'form-control','readonly'=>true]);
    }
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
