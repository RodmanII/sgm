<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\PersonaB */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Personas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="persona-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear Persona', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'codigo',
            'nombre',
            'apellido',
            // 'dui',
            // 'nit',
            'fecha_nacimiento',
            'genero',
            // 'direccion',
            // 'profesion',
            // 'estado',
            // 'cod_municipio',
            // 'cod_nacionalidad',
            // 'cod_estado_civil',
            // 'nombre_usuario',
            // 'otro_doc',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
