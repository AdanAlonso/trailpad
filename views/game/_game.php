<?php
  use yii\helpers\Url;
?>

<div class="thumbnail game state-<?= strtolower($model->state) ?>" title="<?= $model->title ?>" data-id="<?= $model->id ?>">
    <a class="cover" aria-label="<?= $model->title ?>" href="<?= Url::to(['update', 'id' => $model->id]) ?>"></a>
    <div class="caption">
      <h3 class="text-truncate">
        <a href="<?= Url::to(['update', 'id' => $model->id]) ?>"><?= $model->title ?></a>
      </h3>
    </div>
    <div class="caption labels">
      <?php if($model->dlc_of_id) { ?>
        <span class="label label-dlcs"><?= Yii::t('app', 'DLC Platform', ['name' => $model->platform->name]) ?></span>
      <?php } else { ?>
        <?php if($model->emulated_platform_id) { ?>
          <span class="label label-platform"><?= $model->platform->name ?> (<?= $model->emulatedPlatform->name ?>)</span>
        <?php } else { ?>
          <span class="label label-platform"><?= $model->platform->name ?></span>
        <?php } ?>
      <?php } ?>
      <span class="label label-state state-<?= strtolower($model->state) ?>"><?= $model->stateLabel() ?></span>
      <?php if($model->getDlcs()->count()) { ?>
        <span class="label label-dlcs"><?= Yii::t('app', 'DLCs', ['count' => $model->getDlcs()->count()]); ?></span>
      <?php } ?>
    </div>
</div>
