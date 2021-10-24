<?php

namespace app\services;

use app\components\dataProviders\JsonRpcDataProvider;
use app\components\jsonRpc\JsonRpcClient;
use yii\data\Sort;

class JsonRpcService
{
    /** @var string[] */
    const NAME_FIELDS = ['url', 'dateRequest', 'cnt'];
    /** @var string */
    const NAME_METHOD = 'service.list-requests';

    /** @var JsonRpcClient */
    protected JsonRpcClient $jsonRpcClient;
    /** @var JsonRpcDataProvider */
    protected JsonRpcDataProvider $jsonRpcDataProvider;

    /**
     * @param JsonRpcDataProvider $jsonRpcDataProvider
     * @param JsonRpcClient $jsonRpcClient
     */
    public function __construct(
        JsonRpcDataProvider $jsonRpcDataProvider,
        JsonRpcClient $jsonRpcClient
    ) {
        $this->jsonRpcDataProvider = $jsonRpcDataProvider;
        $this->jsonRpcClient = $jsonRpcClient;
    }

    /**
     * @return JsonRpcDataProvider
     * @throws \app\components\jsonRpc\JsonRpcException
     */
    public function createDataProvider(): JsonRpcDataProvider
    {
        $params = \Yii::$app->request->getQueryParams();
        $jsonResponse = $this->jsonRpcClient->run(self::NAME_METHOD, $params);

        $dataProvider = new JsonRpcDataProvider([
            'objectModels' => $jsonResponse,
            'sort' => [
                'class' => Sort::class,
                'params' => $params,
                'enableMultiSort' => true,
                'attributes' => self::NAME_FIELDS,
            ]
        ]);
        $dataProvider->pagination->setPage($jsonResponse->_meta->currentPage - 1);
        $dataProvider->pagination->totalCount = $dataProvider->totalCount;
        $dataProvider->pagination->params = $params;

        return $dataProvider;
    }
}