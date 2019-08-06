<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "platform".
 *
 * @property int $id
 * @property string $name
 */
class Platform extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'platform';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function gameCount()
    {
        return $this->getGames()->count();
    }

    public function getGames(){
        return $this->hasMany(Game::className(), ['platform_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }
}
