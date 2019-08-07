<?php
use yii\widgets\ListView;
?>

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