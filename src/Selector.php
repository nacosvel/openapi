<?php

namespace Nacosvel\OpenAPI;

use Nacosvel\OpenAPI\Contracts\ClientDecorator;

class Selector implements Contracts\Selector
{
    public function __construct(
        protected ClientDecorator $client,
        protected string $uri,
    ) {
        //
    }

    public function client(): ClientDecorator
    {
        return $this->client;
    }

    public function pathname(): string
    {
        return $this->uri;
    }
}
