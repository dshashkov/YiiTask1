<?php

use yii\db\Schema;
use yii\db\Migration;

class m160210_101012_create_content_hashtags extends Migration
{
    public function up()
    {
        $this->createTable('content_hashtags', [
            'tweet_id' => $this->integer(),
            'hashtag_id' => $this->integer(),
            'PRIMARY KEY(tweet_id, hashtag_id)'
        ]);

        $this->createIndex('idx-content_hashtags-tweet_id', 'content_hashtags', 'tweet_id');
        $this->createIndex('idx-content_hashtags-hashtag_id', 'content_hashtags', 'hashtag_id');

        $this->addForeignKey('fk-content_hashtags-tweet_id', 'content_hashtags', 'tweet_id', 'content', 'tweet_id', 'CASCADE');
        $this->addForeignKey('fk-content_hashtags-hashtag_id', 'content_hashtags', 'hashtag_id', 'hashtags', 'hashtag_id', 'CASCADE');

    }

    public function down()
    {
       $this->dropTable('content_hashtags');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
