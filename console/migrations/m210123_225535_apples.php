<?php

use yii\db\Migration;

/**
 * Class m210123_225535_apples
 */
class m210123_225535_apples extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%apples}}', [
            'id' => $this->primaryKey(),
            'born_at' => $this->timestamp(),
            'fell_at' => $this->timestamp(),
            'color' => $this->text(),
            'status' => $this->text(),
            'piece' => $this->tinyInteger()
        ], 'ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210123_225535_apples cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210123_225535_apples cannot be reverted.\n";

        return false;
    }
    */
}
