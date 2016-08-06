<?php
namespace Mosh\KodiCommandLineListener;

use HttpRequest;

class KodiClient
{
    const JSONP_RPC_VERSION = '2.0';

    private $url;

    /**
     * @param string $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * @param JsonPCommand $command
     * @return array
     */
    public function execute(JsonPCommand $command)
    {
        $url = $this->url . '/jsonrpc?request=' . $this->renderGetRequestString($command);
        $body = file_get_contents($url);

        return json_decode($body, true);
    }

    private function renderGetRequestString(JsonPCommand $command)
    {
        $requestArray = array();
        $requestArray['jsonrpc'] = self::JSONP_RPC_VERSION;
        $requestArray['id'] = $command->getId();
        $requestArray['method'] = $command->getMethod();
        $requestArray['params'] = $command->getParams();

        return json_encode($requestArray);
    }
}