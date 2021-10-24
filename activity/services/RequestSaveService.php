<?php

namespace app\services;

use app\forms\RequestSaveForm;
use app\repositories\RequestsLandingRepository;
use JsonRpc2\Exception;
use yii\web\BadRequestHttpException;

class RequestSaveService
{
    /** @var RequestsLandingRepository */
    private RequestsLandingRepository $requestsLanding;

    /**
     * @param RequestsLandingRepository $requestsLanding
     */
    public function __construct(RequestsLandingRepository $requestsLanding)
    {
        $this->requestsLanding = $requestsLanding;
    }

    /**
     * @param RequestSaveForm $requestSave
     * @return string[]
     * @throws BadRequestHttpException
     */
    function save(RequestSaveForm $requestSave): array
    {
        if (!$this->requestsLanding->insert($requestSave->url, $requestSave->date)) {
            throw new BadRequestHttpException("Data not save");
        }

        return ["message" => "Data save"];
    }
}