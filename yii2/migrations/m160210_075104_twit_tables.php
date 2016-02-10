<?php

use yii\db\Schema;
use yii\db\Migration;

class m160210_075104_twit_tables extends Migration
{
//    public function up()
//    {
//
//    }
//
//    public function down()
//    {
//        echo "m160210_075104_twit_tables cannot be reverted.\n";
//
//        return false;
//    }


    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable('content',[
            'tweet_id' => Schema::TYPE_PK,
            'tweet_data' => Schema::TYPE_STRING,
            'tweet_text' => Schema::TYPE_STRING,
            'tweet_db_save' => Schema::TYPE_STRING,
        ],"ENGINE=InnoDB DEFAULT CHARSET=utf8");
        $this->createTable('hashtags',[
            'hashtag_id' => Schema::TYPE_PK,
            'hashtag_value' => Schema::TYPE_STRING,
        ],"ENGINE=InnoDB DEFAULT CHARSET=utf8");
    }

    public function safeDown()
    {
        $this->dropTable('content');
        $this->dropTable('hashtags');
    }

}
