<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\GameSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Games');
$this->params['breadcrumbs'][] = $this->title;

use app\models\Game;

use app\models\Platform;
$platforms = Platform::find()
             ->select(['name'])
             ->indexBy('name')
             ->column();
?>
<div class="game-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Game'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            [
              'label' => Yii::t('app', 'Platform ID'),
              'attribute' => 'platform.name',
              'filter' => $platforms
            ],
            [
              'label' => Yii::t('app', 'State'),
              'attribute' => 'state',
              'value' => function($data) { return $data->state_label(); },
              'filter' => Game::states()
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
