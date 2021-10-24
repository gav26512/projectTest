<?php

namespace app\behavirios;

use app\components\jsonRpc\JsonRpcClient;
use yii\base\Behavior;
use yii\web\Controller;

class LogRequest extends Behavior
{
    /** @var string */
    const NAME_METHOD = 'service.request-save';
    /** @var string */
    private string $site;
    /** @var JsonRpcClient */
    private JsonRpcClient $jsonRpcClient;

    /**
     * @param string|null $site
     * @param array $config
     */
    public function __construct(
        string $site = null,
        JsonRpcClient $jsonRpcClient,
        $config = []
    ) {
        parent::__construct($config);
        if (is_null($site)) {
            $this->site = 'http://landing.local';
        }
        $this->jsonRpcClient = $jsonRpcClient;
    }

    /**
     * @return string[]
     */
    public function events(): array
    {
        return [
            Controller::EVENT_AFTER_ACTION => 'setLogRequest'
        ];
    }

    /**
     * @throws \app\components\jsonRpc\JsonRpcException
     */
    public function setLogRequest()
    {
        $this->jsonRpcClient->run(self::NAME_METHOD, [$this->getAllUrl(), date('Y-m-d')]);
    }

    /**
     * @return string
     */
    private function getAllUrl(): string
    {
        return $this->site . \Yii::$app->request->url;
    }
}