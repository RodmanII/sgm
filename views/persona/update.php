<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\mant\Persona */

$this->title = 'Actualizar Persona: ' . ' ' . $model->codigo;
$this->params['breadcrumbs'][] = ['label' => 'Personas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->codigo, 'url' => ['view', 'id' => $model->codigo]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="persona-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
