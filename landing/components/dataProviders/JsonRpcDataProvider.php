<?php

namespace app\components\dataProviders;

use yii\base\InvalidConfigException;
use yii\data\BaseDataProvider;

class JsonRpcDataProvider extends BaseDataProvider
{
    public object $objectModels;

    /**
     * @var string|callable the column that is used as the key of the data models.
     * This can be either a column name, or a callable that returns the key value of a given data model.
     * If this is not set, the index of the [[models]] array will be used.
     * @see getKeys()
     */
    public $key;

    /**
     * @return array
     * @throws InvalidConfigException
     */
    protected function prepareModels()
    {
        if ($this->objectModels === null) {
            throw new InvalidConfigException('The "objectModels" is null');
        }

        return $this->objectModels->items;
    }

    /**
     * @param array $models
     * @return array|int[]|string[]
     */
    protected function prepareKeys($models)
    {
        $keys = [];
        if ($this->key !== null) {
            foreach ($models as $model) {
                if (is_string($this->key)) {
                    $key = $this->key;
                    $keys[] = $model->$key;
                } else {
                    $keys[] = call_user_func($this->key, $model);
                }
            }

            return $keys;
        }

        return array_keys($models);
    }

    /**
     * @return int
     */
    protected function prepareTotalCount()
    {
        return $this->objectModels->_meta->totalCount;
    }

}