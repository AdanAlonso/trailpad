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
    public function stateLabel()
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
            [['platform_id', 'dlc_of_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['platform_id'], 'exist', 'skipOnError' => true, 'targetClass' => Platform::className(), 'targetAttribute' => ['platform_id' => 'id']],
            [['dlc_of_id'], 'exist', 'skipOnError' => true, 'targetClass' => Game::className(), 'targetAttribute' => ['dlc_of_id' => 'id']],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDlcOf()
    {
        return $this->hasOne(Game::className(), ['id' => 'dlc_of_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDlcs()
    {
        return $this->hasMany(Game::className(), ['dlc_of_id' => 'id']);
    }

    /**
     * Game cover URL from IGDB API
     *
     * @return string
     */
    public function getCover()
    {
        $IGDB_API_KEY = getenv('IGDB_API_KEY');

        if($IGDB_API_KEY == null)
            return;

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\nuser-key: $IGDB_API_KEY\r\n",
                'method'  => 'POST',
                'content' => "fields id, cover.url; search \"$this->title\"; limit 1;",
            )
        );
        $context  = stream_context_create($options);
        $result = json_decode(file_get_contents('https://api-v3.igdb.com/games', false, $context), true);

        if(count($result) == 0 || !isset($result[0]['cover']))
            return;
        
        return $result[0]['cover']['url'];
    }
}
