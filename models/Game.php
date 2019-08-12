<?php

namespace app\models;

use Yii;
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

    public function cover_path()
    {
        return self::$uploads_folder . "$this->id.jpg";
    }

    /**
     * Uses downloaded image cover, or tries to get it from the API
     *
     * @return string
     */
    public function getCover()
    {
        if(!file_exists($this->cover_path())) {
            $this->downloadCover();
        }
        return $this->cover_path();
    }

    public function downloadCover()
    {
        $source = $this->getCoverfromAPI();
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http:' . $source);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSLVERSION, 3);
        $data = curl_exec($curl);
        $error = curl_error($curl); 
        curl_close($curl);
        
        $destination = realpath(Yii::$app->basePath) . '/web/' . $this->cover_path();
        $file = fopen($destination, 'w+');
        fputs($file, $data);
        fclose($file);
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

        if(count($result) == 0 || !isset($result[0]['cover']))
            return;
        
        return $result[0]['cover']['url'];
    }
}
