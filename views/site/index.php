<?php
/* @var $this yii\web\View */
$this->title = 'Sistema de Gestión Municipal';
?>
<div class="site-index">
    <?php if (Yii::$app->session->hasFlash('success')): ?>

    <div class="alert alert-success">
      <?= Yii::$app->session->getFlash('success') ?>
    </div>

    <?php endif; ?>
    <div class="jumbotron">
        <!-- <h1>Sistema de Gestión Municipal</h1> -->

        <!--<p class="lead">Alcaldía Municipal de Ilopango</p> -->

    </div>

    <div class="body-content">
      <p style="text-align:center"><a class="btn btn-info btn-lg" href="http://www.alcaldiadeilopango.gob.sv/" target="_blank" >Visitar Sitio Web</a></p>
    </div>
</div>
