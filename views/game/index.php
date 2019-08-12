<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\GameSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use kartik\select2\Select2;

$this->title = Yii::t('app', 'Games');
$this->params['breadcrumbs'][] = $this->title;

use app\models\Game;
$states = Game::states();

use app\models\Platform;
$platforms = Platform::find()
             ->select(['name'])
             ->indexBy('name')
             ->column();
?>
<div class="game-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Game'), ['create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php $form = ActiveForm::begin(['action' => ['index'], 'method' => 'get']); ?>
      <div class="row">
          <div class="col-sm-12 col-md-5 col-lg-6">
            <?= $form->field($searchModel, 'title')->label(false)->input('title', ['placeholder' => Yii::t('app', 'Title')]) ?>
          </div>
          <div class="col-sm-12 col-md-2">
            <?= $form->field($searchModel, 'platform.name')->label(false)->widget(Select2::classname(), [
              'data' => $platforms,
              'options' => [
                'placeholder' => Yii::t('app', 'Platform ID'),
              ],
              'pluginOptions' => [
                'allowClear' => true
              ]
            ]) ?>
          </div>
          <div class="col-sm-12 col-md-2">
            <?= $form->field($searchModel, 'state')->label(false)->widget(Select2::classname(), [
              'data' => $states,
              'options' => [
                'placeholder' => Yii::t('app', 'State'),
                ],
                'pluginOptions' => [
                  'allowClear' => true
                ]
            ]) ?>
          </div> 
          <div class="col-sm-12 col-md-3 col-lg-2">
            <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Clear'), ['index'], ['class' => 'btn btn-default']) ?>
          </div>
      </div>
    <?php ActiveForm::end(); ?>

    <?= Yii::$app->controller->renderPartial('_index', ['dataProvider' => $dataProvider]); ?>

</div>
