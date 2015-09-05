<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\mant\Lugar */

$this->title = Yii::t('app', 'Create Lugar');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lugars'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lugar-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
