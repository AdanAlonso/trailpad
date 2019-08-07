<?php
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Game */
/* @var $form yii\widgets\ActiveForm */

use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;

use app\models\Platform;

$platforms = Platform::find()
             ->select(['name'])
             ->indexBy('id')
             ->column();

$states = $model::states();
$games = $model::find()
        ->select(['title'])
        ->indexBy('id')
        ->orderBy('title')
        ->column();
?>

<div class="game-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-4">
            <?= $form->field($model, 'platform_id')->widget(Select2::classname(), ['data' => $platforms]) ?>
        </div>
        <div class="col-sm-12 col-md-4">
            <?= $form->field($model, 'state')->widget(Select2::classname(), ['data' => $states]) ?>
        </div> 
        <div class="col-sm-12 col-md-4">
        <?= $form->field($model, 'dlc_of_id')->label(Yii::t('app', 'Dlc of ID'))->widget(Select2::classname(), [
              'data' => $games,
              'options' => [
                'placeholder' => '',
              ],
              'pluginOptions' => [
                'allowClear' => true
              ]
            ]) ?>
        </div> 
    </div>

    <?= Yii::$app->controller->renderPartial('/shared/_form_actions', ['model' => $model]); ?>

    <?php ActiveForm::end(); ?>

</div>
