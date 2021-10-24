<?php

namespace app\components\jsonRpc;

class JsonRpcClient
{
    /** @var string  */
    const URL_LOG = 'http://activity.local/json-rpc';
    /** @var mixed|null  */
    protected $url;

    /**
     * @param null $url
     */
    public function __construct($url = null)
    {
        if($url === null) {
            $this->url = self::URL_LOG;
        } else {
            $this->url = $url;
        }
    }

    /**
     * @param $name
     * @param $arguments
     * @param int $id
     * @return mixed
     * @throws JsonRpcException
     */
    public function run($name, $arguments, $id = 1)
    {
        $request = [
            'jsonrpc' => '2.0',
            'method'  => $name,
            'params'  => $arguments,
            'id'      => $id
        ];

        $jsonRequest = json_encode($request);

        $ctx = stream_context_create([
            'http' => [
                'method'  => 'POST',
                'header'  => "Content-Type: application/json\r\n",
                'content' => $jsonRequest
            ]
        ]);

        $jsonResponse = '';
        try {
            $fp = fopen($this->url, 'r', false, $ctx);
            while ($line = fgets($fp))
            {
                $jsonResponse .= trim($line) . "\n";
            }
            fclose($fp);
        } catch (Exception $e) {
            if (isset($fp) && $fp !== false) {
                fclose($fp);
                throw $e;
            }
        }
        if ($jsonResponse === '')
            throw new JsonRpcException('fopen failed', JsonRpcException::INTERNAL_ERROR);

        $response = json_decode($jsonResponse);

        if ($response === null)
            throw new JsonRpcException('JSON cannot be decoded', JsonRpcException::INTERNAL_ERROR);

        if ($response->id != $id)
            throw new JsonRpcException('Mismatched JSON-RPC IDs', JsonRpcException::INTERNAL_ERROR);

        if (property_exists($response, 'error'))
            throw new JsonRpcException($response->error->message, $response->error->code);
        else if (property_exists($response, 'result'))
            return $response->result;
        else
            throw new JsonRpcException('Invalid JSON-RPC response', JsonRpcException::INTERNAL_ERROR);
    }
}