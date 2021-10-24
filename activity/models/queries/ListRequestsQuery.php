<?php

namespace app\models\queries;

use app\models\records\RequestsLanding;
use yii\db\Query;

class ListRequestsQuery
{
    /**
     * @return Query
     */
    public function query(): Query
    {
        return (new Query())
            ->select([
                'url' => 'url',
                'dateRequest' => 'MAX(date_request)',
                'cnt' => 'COUNT(url)'
            ])
            ->from(['rl' => RequestsLanding::tableName()])
            ->groupBy('url');
    }

    /**
     * @return string[]
     */
    public function sortAttributes(): array
    {
        {
            return [
                'url' => 'url',
                'dateRequest' => 'dateRequest',
                'cnt' => 'cnt'
            ];
        }
    }

    /**
     * @return int
     */
    public function countAll(): int
    {
        return (int) $this->query()->count();
    }
}