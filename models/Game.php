<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;
use yii\helpers\BaseFileHelper;

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

    private static $uploads_folder = 'uploads/game/cover/';    

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

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
            [['platform_id', 'dlc_of_id', 'emulated_platform_id'], 'integer'],
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
            'dlc_of_id' => Yii::t('app', 'DLC of ID'),
            'emulated_platform_id' => Yii::t('app', 'Emulated Platform ID'),
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
    public function getEmulatedPlatform()
    {
        return $this->hasOne(Platform::className(), ['id' => 'emulated_platform_id']);
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
     * Uses downloaded image cover, or tries to get it from the API
     *
     * @return string
     */
    public function getCover()
    {
        if($this->cover == null) {
            return $this->downloadCover();
        }
        return $this->cover;
    }

    public function downloadCover()
    {
        if(getenv('CLOUD_NAME') == null)
            return;
        $result = \Cloudinary\Uploader::upload($this->getCoverfromAPI(), array("public_id" => "game_cover_$this->id"));
        $this->cover = $result['secure_url'];
        $this->save();
    }

    /**
     * Game cover URL from IGDB API
     *
     * @return string
     */
    private function getCoverfromAPI()
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

        if(count($result) == 0 || !isset($result[0]['cover'])) {
            return realpath(Yii::$app->basePath) . '/web/images/logo_square.png';
        }
        
        return 'http:'. $result[0]['cover']['url'];
    }
}
