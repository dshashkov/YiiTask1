<?php

use yii\db\Schema;
use yii\db\Migration;

class m160208_132306_create_table_tweet_hashtags extends Migration
{
    public function up()
    {
        $this->createTable('tweet_hashtags',[
            'id' => Schema::TYPE_PK,
            'tweet_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'hashtags' => Schema::TYPE_STRING
        ],"ENGINE=InnoDB DEFAULT CHARSET=utf8");
    }

    public function down()
    {
        echo "m160208_132306_create_table_tweet_hashtags cannot be reverted.\n";

        return false;
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
