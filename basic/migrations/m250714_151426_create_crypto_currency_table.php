<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%crypto_currency}}`.
 */
class m250714_151426_create_crypto_currency_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%crypto_currency}}', [
            'id' => $this->primaryKey(),
            'symbol' => $this->string(10)->notNull(),
            'name' => $this->string(100)->notNull(),
            'price' => $this->decimal(18, 8)->notNull(),
            'price_change_24h' => $this->decimal(10, 4)->null(),
            'market_cap' => $this->bigInteger()->null(),
            'volume_24h' => $this->bigInteger()->null(),
            'last_updated' => $this->dateTime()->null(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%crypto_currency}}');
    }
}
