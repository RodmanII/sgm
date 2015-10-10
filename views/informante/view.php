<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\mant\Informante */

$this->title = $model->codigo;
$this->params['breadcrumbs'][] = ['label' => 'Informantes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="informante-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->codigo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->codigo], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'codigo',
            'nombre',
            'tipo_documento',
            'numero_documento',
            'genero',
            'cod_persona',
        ],
    ]) ?>

</div>
