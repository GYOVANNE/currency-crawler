<?php

namespace App\Domains\ClientRequest\Adapters;

use App\Domains\ClientRequest\Ports\ClientHttpRequestPort;
use GuzzleHttp\Client as GuzzleClient;

class ClientGuzzleRequestAdapter implements ClientHttpRequestPort {

    public function execute(string $url) {
        $client = new GuzzleClient();
        $response = $client->get($url);
        $html = $response->getBody()->getContents();
        return $html;
    }
}
