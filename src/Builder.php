<?php

namespace Nacosvel\OpenAPI;

/**
 * Chainable the client for sending HTTP requests.
 */
final class Builder
{
    /**
     * Builder Decorator the chainable `GuzzleHttp\Client`
     *
     * @param array $config
     * @param array $options
     *
     * @return Chainable
     */
    public static function factory(array $config = [], array $options = []): Contracts\Chainable
    {
        return new Chainable([], new ClientDecorator($config, $options));
    }

    private function __construct()
    {

    }
}
