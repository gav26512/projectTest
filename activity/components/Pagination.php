<?php

namespace app\components;

use yii\web\Request;

class Pagination extends \yii\data\Pagination
{
    /** @var GetParamsFromRequest  */
    private GetParamsFromRequest $getParamsFromRequest;

    /**
     * @param GetParamsFromRequest $getParamsFromRequest
     * @param array $config
     */
    public function __construct(GetParamsFromRequest $getParamsFromRequest, $config = [])
    {
        parent::__construct($config);
        $this->getParamsFromRequest = $getParamsFromRequest;
    }

    /**
     * @param string $name
     * @param null $defaultValue
     * @return bool|float|int|mixed|string|null
     * @throws \yii\base\InvalidConfigException
     */
    protected function getQueryParam($name, $defaultValue = null)
    {
        if (($params = $this->params) === null) {
            $params = $this->getParamsFromRequest->getParams();
        }

        return isset($params[$name]) && is_scalar($params[$name]) ? $params[$name] : $defaultValue;
    }
}