<?php
  use yii\helpers\Url;
?>

<div class="thumbnail game state-<?= strtolower($model->state) ?>" title="<?= $model->title ?>">
    <a class="cover" href="<?= Url::to(['update', 'id' => $model->id]) ?>"></a>
    <div class="caption">
      <h3 class="text-truncate">
        <a href="<?= Url::to(['update', 'id' => $model->id]) ?>"><?= $model->title ?></a>
      </h3>
      <span class="label label-platform"><?= $model->platform->name ?></span>
      <span class="label label-state state-<?= strtolower($model->state) ?>"><?= $model->stateLabel() ?></span>
      <?php if($model->getDlcs()->count()) { ?>
        <span class="label label-dlcs"><?= Yii::t('app', 'DLCs: {count}', ['count' => $model->getDlcs()->count()]); ?></span>
      <?php } ?>
    </div>
</div>
