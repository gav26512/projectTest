<?php

namespace app\components;

class SortAttributes
{
    /**
     * из массива
     * [
     *   'name' => ['first_name', 'last_name'],
     *   'object' => 'o.object',
     * ]
     *
     * Собирает массив ввиде для работы с сортировкой Sort::class
     * https://www.yiiframework.com/doc/api/2.0/yii-data-sort
     * [
     *  'name' => [
     *         'asc' => ['first_name' => SORT_ASC, 'last_name' => SORT_ASC],
     *         'desc' => ['first_name' => SORT_DESC, 'last_name' => SORT_DESC],
     *   ],
     *  'object' => [
     *         'asc' => ['o.object' => SORT_ASC],
     *         'desc' => ['o.object' => SORT_DESC],
     *  ],
     * ]
     *
     * @param array $attributes
     * @return array
     */
    public function createFromAttributes(array $attributes): array
    {
        $result = [];
        foreach ($attributes as $key => $sortAttribute) {
            $asc = [];
            $desc = [];
            if (is_array($sortAttribute)) {
                foreach ($sortAttribute as $item) {
                    $asc[$item] = SORT_ASC;
                    $desc[$item] = SORT_DESC;
                }
            } else {
                $asc[$sortAttribute] = SORT_ASC;
                $desc[$sortAttribute] = SORT_DESC;
            }

            $result[$key]['asc'] = $asc;
            $result[$key]['desc'] = $desc;
        }

        return $result;
    }

}