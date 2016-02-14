<?php

use yii\db\Schema;
use yii\db\Migration;

class m160214_134507_create_drop_all extends Migration
{
    public function up()
    {
        $this->dropForeignKey('fk-content_hashtags-tweet_id','content_hashtags');
        $this->dropForeignKey('fk-content_hashtags-hashtag_id','content_hashtags');
        $this->dropTable('content');
        $this->dropTable('content_hashtags');
        $this->dropTable('hashtags');
    }

    public function down()
    {
        echo "m160214_134507_create_drop_all cannot be reverted.\n";

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
