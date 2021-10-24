<?php

namespace app\repositories;

use app\models\records\RequestsLanding;

class RequestsLandingRepository
{
    /** @var RequestsLanding */
    private RequestsLanding $requestsLanding;

    /**
     * @param RequestsLanding $requestsLanding
     */
    public function __construct(RequestsLanding $requestsLanding)
    {
        $this->requestsLanding = $requestsLanding;
    }

    /**
     * @param string $url
     * @param string $date
     * @return bool
     */
    public function insert(string $url, string $date): bool
    {
        $this->requestsLanding->url = $url;
        $this->requestsLanding->date_request = $date;

        return $this->requestsLanding->save();
    }
}
