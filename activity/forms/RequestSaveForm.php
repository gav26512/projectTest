<?php

namespace app\forms;

use yii\base\Model;

class RequestSaveForm extends Model
{
    /** @var string  */
    public string $url;
    /** @var string  */
    public string $date;

    public function rules()
    {
        return [
            [['url', 'date'], 'required'],
            [['url'], 'string'],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }
}
