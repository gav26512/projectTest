<?php

namespace app\controllers;

use app\services\JsonRpcService;
use yii\web\Controller;

class AdminController extends Controller
{
    /** @var JsonRpcService  */
    protected JsonRpcService $jsonRpcService;

    /**
     * @param $id
     * @param $module
     * @param JsonRpcService $jsonRpcService
     * @param array $config
     */
    public function __construct(
        $id,
        $module,
        JsonRpcService $jsonRpcService,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->jsonRpcService = $jsonRpcService;
    }

    /**
     * @return string
     * @throws \app\components\jsonRpc\JsonRpcException
     */
    public function actionActivity()
    {
        return $this->render('index',
            [
                'dataProvider' => $this->jsonRpcService->createDataProvider(),
            ]
        );
    }
}
