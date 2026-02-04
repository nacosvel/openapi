<?php

namespace Nacosvel\OpenAPI\Concerns;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Promise\PromiseInterface;
use Nacosvel\OpenAPI\Contracts\ClientDecorator;
use Nacosvel\OpenAPI\Contracts\MiddlewareInterface;
use Nacosvel\OpenAPI\Selector;
use Psr\Http\Message\ResponseInterface;

trait HasChainable
{
    protected array $middlewares = [];

    /**
     * @inheritDoc
     */
    public function getClientDecorator(): ClientDecorator
    {
        return $this->decorator;
    }

    /**
     * @inheritDoc
     */
    public function getClient(): ClientInterface
    {
        return $this->getClientDecorator()->getClient();
    }

    /**
     * @inheritDoc
     */
    public function getClientHandlerStack(): HandlerStack
    {
        return $this->getClient()->getConfig('handler');
    }

    /**
     * @inheritDoc
     */
    public function addMiddleware(array|MiddlewareInterface $middleware): static
    {
        $middlewares = is_array($middleware) ? $middleware : func_get_args();

        foreach ($middlewares as $middleware) {
            $this->middlewares[] = $middleware;
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    /**
     * @inheritDoc
     */
    public function select(string $uri, array $options = []): Selector
    {
        $middlewares = [];

        foreach ($this->getMiddlewares() as $middleware) {
            if (!method_exists($middleware, 'prepare') || $middleware->prepare($uri, $options)) {
                $middlewares[] = $middleware;
            }
        }

        $client = $this->getClientDecorator()
            ->flushMiddleware()
            ->addMiddleware($middlewares);


        $uri = array_reduce($middlewares, function ($uri, MiddlewareInterface $middleware) {
            return method_exists($middleware, 'expand') ? $middleware->expand($uri) : $uri;
        }, $uri);

        return new Selector($client, $uri);
    }

    /**
     * @inheritDoc
     */
    public function get(array $options = []): ResponseInterface
    {
        return with($this->select($this->pathname(), $options), function (Selector $selector) use ($options) {
            return $selector->client()->request('GET', $selector->pathname(), $options);
        });
    }

    /**
     * @inheritDoc
     */
    public function put(array $options = []): ResponseInterface
    {
        return with($this->select($this->pathname(), $options), function (Selector $selector) use ($options) {
            return $selector->client()->request('PUT', $selector->pathname(), $options);
        });
    }

    /**
     * @inheritDoc
     */
    public function post(array $options = []): ResponseInterface
    {
        return with($this->select($this->pathname(), $options), function (Selector $selector) use ($options) {
            return $selector->client()->request('POST', $selector->pathname(), $options);
        });
    }

    /**
     * @inheritDoc
     */
    public function patch(array $options = []): ResponseInterface
    {
        return with($this->select($this->pathname(), $options), function (Selector $selector) use ($options) {
            return $selector->client()->request('PATCH', $selector->pathname(), $options);
        });
    }

    /**
     * @inheritDoc
     */
    public function delete(array $options = []): ResponseInterface
    {
        return with($this->select($this->pathname(), $options), function (Selector $selector) use ($options) {
            return $selector->client()->request('DELETE', $selector->pathname(), $options);
        });
    }

    /**
     * @inheritDoc
     */
    public function getAsync(array $options = []): PromiseInterface
    {
        return with($this->select($this->pathname(), $options), function (Selector $selector) use ($options) {
            return $selector->client()->requestAsync('GET', $selector->pathname(), $options);
        });
    }

    /**
     * @inheritDoc
     */
    public function putAsync(array $options = []): PromiseInterface
    {
        return with($this->select($this->pathname(), $options), function (Selector $selector) use ($options) {
            return $selector->client()->requestAsync('PUT', $selector->pathname(), $options);
        });
    }

    /**
     * @inheritDoc
     */
    public function postAsync(array $options = []): PromiseInterface
    {
        return with($this->select($this->pathname(), $options), function (Selector $selector) use ($options) {
            return $selector->client()->requestAsync('POST', $selector->pathname(), $options);
        });
    }

    /**
     * @inheritDoc
     */
    public function patchAsync(array $options = []): PromiseInterface
    {
        return with($this->select($this->pathname(), $options), function (Selector $selector) use ($options) {
            return $selector->client()->requestAsync('PATCH', $selector->pathname(), $options);
        });
    }

    /**
     * @inheritDoc
     */
    public function deleteAsync(array $options = []): PromiseInterface
    {
        return with($this->select($this->pathname(), $options), function (Selector $selector) use ($options) {
            return $selector->client()->requestAsync('DELETE', $selector->pathname(), $options);
        });
    }
}
