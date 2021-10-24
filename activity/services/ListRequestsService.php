<?php

namespace app\services;

use app\components\CreateActiveDataProvider;
use app\components\GetParamsFromRequest;
use app\components\Pagination;
use app\components\SortAttributes;
use app\models\queries\ListRequestsQuery;

class ListRequestsService
{
    /** @var CreateActiveDataProvider */
    private CreateActiveDataProvider $activeDataProvider;
    /** @var ListRequestsQuery */
    private ListRequestsQuery $listRequestsQuery;
    /** @var SortAttributes */
    private SortAttributes $sortAttributes;
    /** @var GetParamsFromRequest */
    private GetParamsFromRequest $params;
    /** @var Pagination */
    private Pagination $pagination;

    /**
     * @param CreateActiveDataProvider $activeDataProvider
     * @param SortAttributes $sortAttributes
     * @param ListRequestsQuery $listRequestsQuery
     * @param GetParamsFromRequest $params
     * @param Pagination $pagination
     */
    public function __construct(
        CreateActiveDataProvider $activeDataProvider,
        SortAttributes $sortAttributes,
        ListRequestsQuery $listRequestsQuery,
        GetParamsFromRequest $params,
        Pagination $pagination
    ) {
        $this->activeDataProvider = $activeDataProvider;
        $this->sortAttributes = $sortAttributes;
        $this->listRequestsQuery = $listRequestsQuery;
        $this->params = $params;
        $this->pagination = $pagination;
    }

    /**
     * @return object
     * @throws \yii\base\InvalidConfigException
     */
    public function create()
    {
        $query = $this->listRequestsQuery->query();
        $sortAttributes = $this->sortAttributes->createFromAttributes($this->listRequestsQuery->sortAttributes());
        $params = $this->params->getParams();
        $perPage = $this->pagination->defaultPageSize;

        if (array_key_exists('per-page', $params)) {
            $perPage = $params['per-page'];
        }
        $object = $this->activeDataProvider->create($query, $sortAttributes);

        return [
            'items' => $object,
            '_meta' => [
                'totalCount' => $object->pagination->totalCount,
                'pageCount' => $object->pagination ? $object->pagination->getPageCount() : 0,
                'currentPage' => $object->pagination ? $object->pagination->getPage() + 1 : 1,
                'perPage' => $object->pagination ? $object->pagination->getPageSize() : 0,
            ],
        ];
    }
}