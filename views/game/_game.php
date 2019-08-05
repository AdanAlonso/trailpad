<?php
  use yii\helpers\Url;
?>

<div class="thumbnail game" title="<?= $model->title ?>">
    <a class="cover" href="<?= Url::to(['update', 'id' => $model->id]) ?>"></a>
    <div class="caption">
      <h3 class="text-truncate">
        <a href="<?= Url::to(['update', 'id' => $model->id]) ?>"><?= $model->title ?></a>
      </h3>
      <span class="label label-primary"><?= $model->platform->name ?></span>
      <span class="label state-<?= strtolower($model->state) ?>"><?= $model->state_label() ?></span>
    </div>
</div>
