<?php

use yii\helpers\Html;
use yii\widgets\ListView;
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
        <?= Html::a(Yii::t('app', 'Create Game'), ['create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= ListView::widget([
      'dataProvider' => $dataProvider,
      'itemView' => '_game',
      'itemOptions' => [
        'class' => 'col-sm-12 col-md-6 col-lg-3'
      ],
      'layout' => '<div class="row"><div class="col-sm-12">{summary}</div></div><div class="row">{items}</div><div class="row"><div class="col-sm-12">{pager}</div></div>',
      'pager' => [
        'firstPageLabel' => '«',
        'lastPageLabel' => '»',
        'prevPageLabel' => '‹',
        'nextPageLabel' => '›',
        'maxButtonCount' => 3,
      ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
