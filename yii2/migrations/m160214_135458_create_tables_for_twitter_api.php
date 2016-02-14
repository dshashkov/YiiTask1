<?php

use yii\db\Schema;
use yii\db\Migration;

class m160214_135458_create_tables_for_twitter_api extends Migration
{
    /*
    public function up()
    {

    }

    public function down()
    {
        echo "m160214_135458_create_tables_for_twitter_api cannot be reverted.\n";

        return false;
    }
*/

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable('tweet',[
            'id' => Schema::TYPE_PK,
            'text' => Schema::TYPE_STRING.' NOT NULL',
            'date_written' => Schema::TYPE_STRING.' NOT NULL',
            'date_imported' => Schema::TYPE_STRING.' NOT NULL',
        ],"ENGINE=InnoDB DEFAULT CHARSET=utf8");
        $this->createTable('hashtag',[
            'text' => $this->string(),
            'PRIMARY KEY(text)'
        ],"ENGINE=InnoDB DEFAULT CHARSET=utf8");
        $this->createTable('tweet_hashtag', [
            'tweet_id' => $this->integer(),
            'hashtag_text' => $this->string(),
            'PRIMARY KEY(tweet_id, hashtag_text)'
        ],"ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->createIndex('idx-tweet_hashtag-tweet_id', 'tweet_hashtag', 'tweet_id');
        $this->createIndex('idx-tweet_hashtag-hashtag_text', 'tweet_hashtag', 'hashtag_text');

        $this->addForeignKey('fk-tweet_hashtag-tweet_id', 'tweet_hashtag', 'tweet_id', 'tweet', 'id', 'CASCADE');
        $this->addForeignKey('fk-tweet_hashtag-hashtag_text', 'tweet_hashtag', 'hashtag_text', 'hashtag', 'text', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-tweet_hashtag-tweet_id','tweet_hashtag');
        $this->dropForeignKey('fk-tweet_hashtag-hashtag_text','tweet_hashtag');
        $this->dropTable('tweet');
        $this->dropTable('tweet_hashtag');
        $this->dropTable('hashtag');
    }

}
