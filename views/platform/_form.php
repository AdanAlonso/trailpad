<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Platform */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="platform-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= Yii::$app->controller->renderPartial('/shared/_form_actions', ['model' => $model]); ?>

    <?php ActiveForm::end(); ?>

</div>
