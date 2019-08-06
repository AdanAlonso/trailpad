<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PlatformSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Platforms');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="platform-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <?= Html::a(Yii::t('app', 'Create Platform'), ['create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => '<div class="row"><div class="col-sm-12">{summary}</div></div><div class="row"><div class="col-sm-12">{items}</div></div><div class="row"><div class="col-sm-12">{pager}</div></div>',
        'columns' => [
            [
                'format' => 'raw',
                'attribute' => 'name',
                'value'=>function ($model) {
                    return Html::a($model->name, ['update', 'id' => $model->id]);
                },
            ],
            [
                'label' => Yii::t('app', 'Games'),
                'value' => function($model) { return $model->gameCount(); },
            ],
        ],
    ]); ?>


</div>
