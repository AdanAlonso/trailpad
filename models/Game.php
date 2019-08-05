<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "game".
 *
 * @property int $id
 * @property int $platform_id
 * @property string $title
 * @property string $state
 *
 * @property Platform $platform
 */
class Game extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'game';
    }

    /**
     * Possible states for a Game.
     *
     * @return array
     */
    public static function states()
    {
        return [
          'New' => Yii::t('app/states', 'New'),
          'Started' => Yii::t('app/states', 'Started'),
          'Finished' => Yii::t('app/states', 'Finished'),
          'Completed' => Yii::t('app/states', 'Completed'),
          'Ignored' => Yii::t('app/states', 'Ignored'),
        ];
    }

    /**
     * Translated label for state.
     *
     * @return string
     */
    public function state_label()
    {
        return Yii::t('app/states', $this->state);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'platform_id', 'state'], 'required'],
            [['platform_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['platform_id'], 'exist', 'skipOnError' => true, 'targetClass' => Platform::className(), 'targetAttribute' => ['platform_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'platform_id' => Yii::t('app', 'Platform ID'),
            'title' => Yii::t('app', 'Title'),
            'state' => Yii::t('app', 'State'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlatform()
    {
        return $this->hasOne(Platform::className(), ['id' => 'platform_id']);
    }
}
