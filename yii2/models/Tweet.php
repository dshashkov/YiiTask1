<?php

namespace app\models;

use Yii;
use DateTime;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tweet".
 *
 * @property integer $id
 * @property string $text
 * @property string $date_written
 * @property string $date_imported
 *
 * @property TweetHashtag[] $tweetHashtags
 * @property Hashtag[] $hashtagTexts
 */
class Tweet extends ActiveRecord
{
    /**
     * @param $tweetText
     * @param $dateWriten
     * @return Tweet
     */
    public static function createInstanceFromParam($tweetText, $dateWriten)
    {
        $dateImportedFormat = new DateTime('now');
        $dateImportedForSave  = $dateImportedFormat->format('F j, Y-m-d H:i:s');
        $tweet = new Tweet();
        $tweet->text = $tweetText;
        $tweet->date_written = $dateWriten;
        $tweet->date_imported = $dateImportedForSave;
        return $tweet;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tweet';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text', 'date_written', 'date_imported'], 'required'],
            [['date_written', 'date_imported'], 'safe'],
            [['text'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'date_written' => 'Date Written',
            'date_imported' => 'Date Imported',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTweetHashtags()
    {
        return $this->hasMany(TweetHashtag::className(), ['tweet_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHashtagTexts()
    {
        return $this->hasMany(Hashtag::className(), ['text' => 'hashtag_text'])->viaTable('tweet_hashtag', ['tweet_id' => 'id']);
    }
}
