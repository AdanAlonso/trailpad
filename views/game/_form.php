<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Game */
/* @var $form yii\widgets\ActiveForm */

use kartik\select2\Select2;

use app\models\Platform;

$platforms = Platform::find()
             ->select(['name'])
             ->indexBy('id')
             ->column();

$states = $model::states();
?>

<div class="game-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-12 col-md-6">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-12 col-md-3">
            <?= $form->field($model, 'platform_id')->widget(Select2::classname(), ['data' => $platforms]) ?>
        </div>
        <div class="col-sm-12 col-md-3">
            <?= $form->field($model, 'state')->widget(Select2::classname(), ['data' => $states]) ?>
        </div> 
    </div>
    
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), ['index'], [
            'class' => 'btn btn-default',
        ]) ?>
        <?php if($model->id) { ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger right',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        <?php } ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
