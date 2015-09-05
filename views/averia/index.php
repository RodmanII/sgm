<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\AveriaB */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Averias');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="averia-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Averia'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'codigo',
            'fecha',
            'hora',
            'descripcion',
            'gravedad',
            // 'num_vehiculo',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
