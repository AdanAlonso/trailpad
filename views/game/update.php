<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Game */

$this->title = Yii::t('app', 'Update Game: {title}', [
    'title' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Games'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

use yii\data\ActiveDataProvider;
$dataProvider = new ActiveDataProvider([
    'query' => $model::find()->where(['dlc_of_id' => $model->id])->orderBy('title'),
    'pagination' => [
        'pageSize' => 10,
    ],
]);
?>
<div class="game-update">

    <div class="row">
        <div class="col-sm-12 col-md-3"><?= Yii::$app->controller->renderPartial('_game', ['model' => $model]); ?></div>
        <div class="col-sm-12 col-md-9">
            <h1><?= Html::encode($this->title) ?></h1>

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

    <?php if($model->getDlcs()->count()) { ?>
    <div class="row">
        <div class="col-sm-12">
            <h2>DLCs</h2>
            <?= Yii::$app->controller->renderPartial('_index', ['dataProvider' => $dataProvider]); ?>
        </div>
    </div>
    <?php } ?>

</div>
