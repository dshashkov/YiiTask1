<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tweet_hashtag".
 *
 * @property integer $tweet_id
 * @property string $hashtag_text
 *
 * @property Hashtag $hashtagText
 * @property Tweet $tweet
 */
class TweetHashtag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tweet_hashtag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tweet_id', 'hashtag_text'], 'required'],
            [['tweet_id'], 'integer'],
            [['hashtag_text'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tweet_id' => 'Tweet ID',
            'hashtag_text' => 'Hashtag Text',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHashtagText()
    {
        return $this->hasOne(Hashtag::className(), ['text' => 'hashtag_text']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTweet()
    {
        return $this->hasOne(Tweet::className(), ['id' => 'tweet_id']);
    }
}
