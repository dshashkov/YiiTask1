<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hashtag".
 *
 * @property string $text
 *
 * @property TweetHashtag[] $tweetHashtags
 * @property Tweet[] $tweets
 */
class Hashtag extends \yii\db\ActiveRecord
{
    /**
     * @param $hashtag
     * @return Hashtag
     */
    public static function createInstanceFromParam($hashtag)
    {
        $hashtagTable = new Hashtag();
        $hashtagTable->text = $hashtag;
        return $hashtagTable;
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hashtag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text'], 'required'],
            [['text'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'text' => 'Text',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTweetHashtags()
    {
        return $this->hasMany(TweetHashtag::className(), ['hashtag_text' => 'text']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTweets()
    {
        return $this->hasMany(Tweet::className(), ['id' => 'tweet_id'])->viaTable('tweet_hashtag', ['hashtag_text' => 'text']);
    }

    /**
     * @inheritdoc
     * @return HashtagQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new HashtagQuery(get_called_class());
    }
}
