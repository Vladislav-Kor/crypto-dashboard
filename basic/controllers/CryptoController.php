<?php

namespace app\controllers;

use Yii;
use yii\filters\Cors;
use yii\web\Response;
use yii\web\Controller;
use app\models\CryptoCurrency;
use yii\data\ActiveDataProvider;
use yii\filters\ContentNegotiator;

class CryptoController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Добавляем фильтр CORS
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['http://localhost:5173'], // разрешаем запросы с фронтенда
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Allow-Headers' => ['Content-Type', 'Authorization', 'X-Requested-With'],
            ],
        ];

        // Добавляем contentNegotiator для JSON-ответов
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'only' => ['index', 'view', 'create', 'update', 'delete'], // или перечислите нужные действия
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        return $behaviors;
    }
    // Отключаем CSRF для API
    public $enableCsrfValidation = false;



    /**
     * Экшен для получения списка криптовалют
     * URL: /crypto/index
     * Параметры GET:
     * - page (номер страницы, по умолчанию 1)
     * - per-page (кол-во записей на страницу, по умолчанию 10)
     * - sort (поле для сортировки, например price, market_cap, price_change_24h)
     * - order (asc или desc, по умолчанию asc)
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $page = max(1, (int)$request->get('page', 1));
        $perPage = min(50, max(1, (int)$request->get('per-page', 10)));
        $sortField = $request->get('sort', 'market_cap');
        $order = strtolower($request->get('order', 'desc')) === 'asc' ? SORT_ASC : SORT_DESC;
        // Разрешённые поля сортировки
        $allowedSortFields = ['price', 'market_cap', 'price_change_24h', 'volume_24h', 'symbol'];
        if (!in_array($sortField, $allowedSortFields, true)) {
            $sortField = 'market_cap';
        }

        $query = CryptoCurrency::find();
        $query->orderBy([$sortField => $order]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $perPage,
                'page' => $page - 1,
            ],
        ]);
        $models = $dataProvider->getModels();
        $result = [
            'totalCount' => $dataProvider->getTotalCount(),
            'pageCount' => $dataProvider->getPagination()->getPageCount(),
            'currentPage' => $page,
            'perPage' => $perPage,
            'items' => [],
        ];

        foreach ($models as $model) {
            $result['items'][] = [
                'symbol' => $model->symbol,
                'name' => $model->name,
                'price' => (float)$model->price,
                'price_change_24h' => (float)$model->price_change_24h,
                'market_cap' => (float)$model->market_cap,
                'volume_24h' => (float)$model->volume_24h,
                'last_updated' => $model->last_updated,
            ];
        }

        return $result;
    }
}
