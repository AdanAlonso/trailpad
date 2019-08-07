<?php
use yii\helpers\Html;
?>

<div class="form-group">
    <?php if($model->id) { ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    <?php } ?>
    <div class="right">
      <?= Html::a(Yii::t('app', 'Cancel'), ['index'], [
          'class' => 'btn btn-default',
      ]) ?>
      <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>
</div>