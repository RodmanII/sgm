<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'Alcaldía Municipal de Ilopango',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => 'Inicio', 'url' => ['/site/index']],
                    ['label' => 'Registro Familiar', 'visible'=>!Yii::$app->user->isGuest &&
                    (Yii::$app->user->identity->codRol->nombre=='EmpleadoRF'||Yii::$app->user->identity->codRol->nombre=='Administrador'), 'items'=>[
                      ['label' => 'Nacimiento', 'url' => ['/registro/nacimiento']],
                      ['label' => 'Defunción', 'url' => ['/registro/defuncion']],
                      ['label' => 'Matrimonio', 'url' => ['/registro/matrimonio']],
                      ['label' => 'Divorcio', 'url' => ['/registro/divorcio']],
                      ['label' => 'Emisión de Partidas', 'url' => ['/registro/emision']],
                    ]],
                    ['label' => 'Recolección de Desechos', 'visible'=>!Yii::$app->user->isGuest &&
                    (Yii::$app->user->identity->codRol->nombre=='EmpleadoRD'||Yii::$app->user->identity->codRol->nombre=='Administrador'), 'items'=>[
                      ['label' => 'Bitácora de Recolección', 'url' => ['/recoleccion/brecoleccion']],
                      ['label' => 'Recargas', 'url' => ['/recoleccion/recarga']],
                      ['label' => 'Averías', 'url' => ['/recoleccion/averia']],
                    ]],
                    ['label' => 'Vehículo', 'visible'=>!Yii::$app->user->isGuest &&
                    (Yii::$app->user->identity->codRol->nombre=='EmpleadoRD'||Yii::$app->user->identity->codRol->nombre=='Administrador'), 'items'=>[
                        ['label'=>'Cuadrillas', 'url' => ['/recoleccion/cuadrilla']],
                        ['label'=>'Lugares', 'url' => ['/recoleccion/lugares']],
                        ['label'=>'Días', 'url' => ['/recoleccion/dias']],
                    ]],
                    ['label' => 'Administración', 'visible'=>!Yii::$app->user->isGuest &&
                      (Yii::$app->user->identity->codRol->nombre=='Administrador'), 'items'=>[
                      ['label' => 'Mantenimientos', 'url' => ['/admin/mantenimientos']],
                      ['label' => 'Reportes', 'url' => ['/admin/reportes']],
                      ]],
                    Yii::$app->user->isGuest ?
                        ['label' => 'Ingreso', 'url' => ['/site/login']] :
                        ['label' => 'Logout (' . Yii::$app->user->identity->persona->nombre. ')',
                            'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
            NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; Rodrigo Grijalva <?= date('Y') ?></p>
            <p class="pull-right">Potenciado por <a href='http://www.yiiframework.com/' target='_blank'/>Yii Framework</a></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php
  $this->registerCssFile(Yii::$app->homeUrl."css/custom.css");
  $this->endPage();
?>
