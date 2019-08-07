<?php

use yii\helpers\Html;
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

use yii\data\ActiveDataProvider;
$dataProvider = new ActiveDataProvider([
    'query' => $model::find()->where(['dlc_of_id' => $model->id])->orderBy('title'),
    'pagination' => [
        'pageSize' => 10,
    ],
]);
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

    <div class="row">
        <div class="col-sm-12">
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

    <?php if($model->id && $model->getDlcs()->count()) { ?>
        <h2>DLCs</h2>
        <?= Yii::$app->controller->renderPartial('_index', ['dataProvider' => $dataProvider]); ?>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>
