<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "crypto_currency".
 *
 * @property int $id
 * @property string $symbol
 * @property string $name
 * @property float $price
 * @property float|null $price_change_24h
 * @property int|null $market_cap
 * @property int|null $volume_24h
 * @property string|null $last_updated
 */
class CryptoCurrency extends ActiveRecord
{
    public static function tableName()
    {
        return 'crypto_currency';
    }

    public function rules()
    {
        return [
            [['symbol', 'name', 'price'], 'required'],
            [['price', 'price_change_24h'], 'number'],
            [['market_cap', 'volume_24h'], 'integer'],
            [['last_updated'], 'safe'],
            [['symbol'], 'string', 'max' => 10],
            [['name'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'symbol' => 'Symbol',
            'name' => 'Name',
            'price' => 'Price',
            'price_change_24h' => 'Price Change (24h)',
            'market_cap' => 'Market Cap',
            'volume_24h' => 'Volume (24h)',
            'last_updated' => 'Last Updated',
        ];
    }
}
