<?php

use yii\db\Schema;
use yii\db\Migration;

class m160208_130257_add_colum_db_save_data_delete_colum_hashtags extends Migration
{
    public function up()
    {
        $this->addColumn('twit_api','db_save_date',$this->string());
        $this->dropColumn('twit_api','hashtags');
    }

    public function down()
    {
        $this->dropColumn('twit_api','db_save_date');
        $this->addColumn('twit_api','hashtags',$this->string());
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
