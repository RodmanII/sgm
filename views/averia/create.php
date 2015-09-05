<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\mant\Averia */

$this->title = Yii::t('app', 'Create Averia');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Averias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="averia-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
