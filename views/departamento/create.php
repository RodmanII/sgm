<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\mant\Departamento */

$this->title = Yii::t('app', 'Create Departamento');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Departamentos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="departamento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
