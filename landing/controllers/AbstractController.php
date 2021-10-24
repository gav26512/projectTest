<?php

namespace app\controllers;

use app\behavirios\LogRequest;
use yii\web\Controller;

class AbstractController extends Controller
{
    /**
     * @return \string[][]
     */
    public function behaviors()
    {
        return [
            'requestOut' => [
                'class' => LogRequest::class
            ]
        ];
    }
}
