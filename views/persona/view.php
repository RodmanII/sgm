<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'codigo',
            'nombre',
            'apellido',
            'dui',
            'nit',
            'fecha_nacimiento',
            'genero',
            'direccion',
            'profesion',
            'estado',
            'cod_municipio',
            'cod_nacionalidad',
            'cod_estado_civil',
            'nombre_usuario',
            'otro_doc',
        ],
    ]) ?>

</div>
