<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\mant\Informante */

$this->title = Yii::t('app', 'Create Informante');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Informantes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="informante-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
