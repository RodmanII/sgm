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
            'tipo_documento',
            'numero_documento',
            'genero',
            [
              'attribute'=>'cod_persona',
              'format'=>'raw',
              'value'=>retornarDato($model, 'Persona'),
            ],
            'firma',
        ],
    ]) ?>

</div>
