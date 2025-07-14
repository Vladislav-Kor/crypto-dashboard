<?php

namespace app\commands;

use yii\console\Controller;
use app\models\CryptoCurrency;

class CryptoController extends Controller
{
    public function actionFetch()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->get('https://api.coingecko.com/api/v3/coins/markets', [
            'query' => [
                'vs_currency' => 'usd',
                'order' => 'market_cap_desc',
                'per_page' => 50,
                'page' => 1,
                'sparkline' => false,
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        foreach ($data as $coin) {
            $model = CryptoCurrency::findOne(['symbol' => $coin['symbol']]) ?? new CryptoCurrency();
            $model->symbol = $coin['symbol'];
            $model->name = $coin['name'];
            $model->price = $coin['current_price'];
            $model->price_change_24h = $coin['price_change_percentage_24h'];
            $model->market_cap = $coin['market_cap'];
            $model->volume_24h = $coin['total_volume'];
            $model->last_updated = date('Y-m-d H:i:s', strtotime($coin['last_updated']));
            $model->save();
        }
    }
}
