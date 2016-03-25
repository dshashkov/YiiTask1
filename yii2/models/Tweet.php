<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "tweet".
 *
 * @property integer   $id
 * @property string    $text
 * @property string    $date_written
 * @property string    $date_imported
 *
 * @property Hashtag[] $hashtagTexts
 */
class Tweet extends ActiveRecord
{
    /**
     * @param $text
     * @param $dateWriten
     *
     * @return Tweet
     */
    public static function createInstanceFromParam($text, $dateWriten)
    {
        $tweet                = new Tweet();
        $tweet->text          = $text;
        $tweet->date_written  = $dateWriten;
        $tweet->date_imported = new Expression('NOW()');

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
            [['text'], 'required'],
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
            'id'            => 'ID',
            'text'          => 'Text',
            'date_written'  => 'Date Written',
            'date_imported' => 'Date Imported',
        ];
    }

    /**
     * @inheritdoc
     * @return TweetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TweetQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHashtagTexts()
    {
        return $this->hasMany(Hashtag::className(), ['text' => 'hashtag_text'])->viaTable('tweet_hashtag', ['tweet_id' => 'id']);
    }
}
