<?php

namespace app\components;

use Yii;
use yii\web\BadRequestHttpException;

class GetParamsFromRequest
{
    /**
     * @return mixed
     * @throws BadRequestHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function getParams()
    {
        $params = Yii::$app->request->getBodyParams();
        if (!array_key_exists('params', $params)){
            throw new BadRequestHttpException('No params in data');
        }

        return $params['params'];
    }
}