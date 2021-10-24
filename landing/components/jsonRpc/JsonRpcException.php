<?php

namespace app\components\jsonRpc;

use yii\console\Exception;

class JsonRpcException extends Exception
{
    /** @var int */
    const PARSE_ERROR = -32700;
    /** @var int */
    const INVALID_REQUEST = -32600;
    /** @var int */
    const METHOD_NOT_FOUND = -32601;
    /** @var int */
    const INVALID_PARAMS = -32602;
    /** @var int */
    const INTERNAL_ERROR = -32603;

    /** @var mixed|null */
    private $data = null;

    /**
     * @param $message
     * @param $code
     * @param null $data
     */
    public function __construct($message, $code, $data = null)
    {
        $this->data = $data;
        parent::__construct($message, $code);
    }

    /**
     * @return array
     */
    public function getErrorAsArray(): array
    {
        $result = [
            'code' => $this->getCode(),
            'message' => $this->getMessage(),
        ];
        if ($this->data !== null) {
            $result['data'] = $this->data;
        }

        return $result;
    }
}