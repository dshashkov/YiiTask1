<?php

use yii\db\Schema;
use yii\db\Migration;

class m160207_151335_create_twitdb extends Migration
{
    public function up()
    {
        $this->createTable('twit_api',[
            'id' => Schema::TYPE_PK,
            'tweet_text' => Schema::TYPE_STRING . ' NOT NULL',
            'tweet_data' => Schema::TYPE_STRING . ' NOT NULL',
            'hashtags' => Schema::TYPE_STRING
       ],"ENGINE=InnoDB DEFAULT CHARSET=utf8");
    }

    public function down()
    {
        echo "m160207_151335_create_twitdb cannot be reverted.\n";

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
