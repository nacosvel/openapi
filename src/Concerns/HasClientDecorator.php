<?php

namespace Nacosvel\OpenAPI\Concerns;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Nacosvel\OpenAPI\Contracts\ClientDecorator;
use Nacosvel\OpenAPI\Contracts\MiddlewareInterface;

trait HasClientDecorator
{
    protected ?ClientInterface $client = null;

    protected array $middlewares = [];

    /**
     * @return ClientInterface
     */
    public function getClient(): ClientInterface
    {
        return $this->client ??= new Client($this->getOptions());
    }

    /**
     * @param ClientInterface $client
     *
     * @return ClientDecorator
     */
    public function setClient(ClientInterface $client): ClientDecorator
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return static
     */
    public function flushMiddleware(): static
    {
        $this->middlewares = [];

        return $this;
    }

    /**
     * @param array|MiddlewareInterface $middleware
     *
     * @return static
     */
    public function addMiddleware(array|MiddlewareInterface $middleware): static
    {
        $middlewares = is_array($middleware) ? $middleware : func_get_args();

        foreach ($middlewares as $middleware) {
            if (is_subclass_of($middleware, MiddlewareInterface::class)) {
                $this->middlewares[] = $middleware;
            }
        }

        return $this;
    }

    /**
     * Get all middlewares
     *
     * @return array
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}
