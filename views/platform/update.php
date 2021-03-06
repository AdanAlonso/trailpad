<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Platform */

$this->title = Yii::t('app', 'Update Platform: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Platforms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="platform-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
