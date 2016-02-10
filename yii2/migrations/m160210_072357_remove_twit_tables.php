<?php

use yii\db\Schema;
use yii\db\Migration;

class m160210_072357_remove_twit_tables extends Migration
{
    public function safeUp()
    {
        $this->dropTable('tweet_hashtags');
        $this->dropTable('twit_api');

    }

    public function down()
    {
        echo "m160210_072357_remove_twit_tables cannot be reverted.\n";

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
