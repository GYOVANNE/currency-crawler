<?php

namespace App\Domains\ClientRequest\Ports;

interface ClientHttpRequestPort {
    public function execute(string $url);
}
