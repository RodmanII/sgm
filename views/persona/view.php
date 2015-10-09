<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\mant\Municipio;
use app\models\mant\EstadoCivil;
use app\models\mant\Nacionalidad;

/* @var $this yii\web\View */
/* @var $model app\models\mant\Persona */

$this->title = $model->codigo;
$this->params['breadcrumbs'][] = ['label' => 'Personas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="persona-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->codigo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->codigo], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Esta seguro de que desea eliminar este registro?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php require_once('../auxiliar/Auxiliar.php'); ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'codigo',
            'nombre',
            'apellido',
            'dui',
            'nit',
            [
              'attribute'=>'fecha_nacimiento',
              'format'=>'raw',
              'value'=>fechaComun($model->fecha_nacimiento),
            ],
            'genero',
            'direccion',
            'profesion',
            'estado',
            [
              'attribute'=>'cod_municipio',
              'format'=>'raw',
              'value'=>retornarDato($model, 'Municipio'),
            ],
            [
              'attribute'=>'cod_nacionalidad',
              'format'=>'raw',
              'value'=>retornarDato($model, 'Nacionalidad'),
            ],
            [
              'attribute'=>'cod_estado_civil',
              'format'=>'raw',
              'value'=>retornarDato($model, 'EstadoCivil'),
            ],
            'nombre_usuario',
            'otro_doc',
        ],
    ]) ?>

</div>
