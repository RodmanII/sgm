<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\mant\CausaDefuncion */

$this->title = 'Create Causa Defuncion';
$this->params['breadcrumbs'][] = ['label' => 'Causa Defuncions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="causa-defuncion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
