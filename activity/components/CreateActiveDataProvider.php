<?php

namespace app\components;

use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Sort;
use yii\db\Query;

class CreateActiveDataProvider
{
    /** @var GetParamsFromRequest */
    protected GetParamsFromRequest $getParamsFromRequest;

    /**
     * CreateObject constructor.
     */
    public function __construct(GetParamsFromRequest $getParamsFromRequest)
    {
        $this->getParamsFromRequest = $getParamsFromRequest;
    }

    /**
     * @param Query $query
     * @param array $sortAttributes
     * @return object
     * @throws \yii\base\InvalidConfigException
     */
    public function create(Query $query, array $sortAttributes = []): object
    {
        $params = $this->getParamsFromRequest->getParams();
        $pagination = [
            'class' => Pagination::class,
            'totalCount' => $query->count(),
        ];

        if (array_key_exists('per-page', $params) && $params['per-page'] === 0) {
            $pagination = false;
        }

        return Yii::createObject(
            [
                'class' => ActiveDataProvider::className(),
                'query' => $query,
                'pagination' => $pagination,
                'sort' => [
                    'class' => Sort::class,
                    'params' => $params,
                    'enableMultiSort' => true,
                    'attributes' => $sortAttributes,
                ],
            ]
        );
    }
}