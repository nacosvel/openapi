<?php

namespace Nacosvel\OpenAPI;

use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\UriTemplate\UriTemplate;
use Nacosvel\OpenAPI\Concerns\HasClientDecorator;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ClientDecorator implements Contracts\ClientDecorator
{
    use HasClientDecorator;

    public function __construct(
        protected array $config = [],
        protected array $options = [],
    ) {
        //
    }

    /**
     * @param array $config
     *
     * @return static
     */
    public function config(array $config = []): static
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @param string|null $key
     * @param mixed|null  $default
     *
     * @return mixed
     */
    public function getConfig(string $key = null, mixed $default = null): mixed
    {
        if (is_null($key)) {
            return $this->config;
        }

        return $this->config[$key] ?? $default;
    }

    /**
     * @param array $options
     *
     * @return static
     */
    public function options(array $options = []): static
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @param string|null $key
     * @param mixed|null  $default
     *
     * @return mixed
     */
    public function option(string $key = null, mixed $default = null): mixed
    {
        if (is_null($key)) {
            return $this->options;
        }

        return $this->options[$key] ?? $default;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Create and send an HTTP request.
     *
     * Use an absolute path to override the base path of the client, or a
     * relative path to append to the base path of the client. The URL can
     * contain the query string as well.
     *
     * @param string $method  HTTP method.
     * @param string $uri     URI object or string.
     * @param array  $options Request options to apply.
     *
     * @return ResponseInterface The `Psr\Http\Message\ResponseInterface` instance
     */
    public function request(string $method, string $uri = '', array $options = []): ResponseInterface
    {
        $handler = new Pipeline(function (RequestInterface $request) use ($options) {
            return $this->getClient()->send($request, $options);
        }, $this->getMiddlewares());

        return $handler->handle(new Request($method, UriTemplate::expand($uri, $options)))->wait();
    }

    /**
     * Create and send an asynchronous HTTP request.
     *
     * Use an absolute path to override the base path of the client, or a
     * relative path to append to the base path of the client. The URL can
     * contain the query string as well. Use an array to provide a URL
     * template and additional variables to use in the URL template expansion.
     *
     * @param string $method  HTTP method
     * @param string $uri     URI object or string.
     * @param array  $options Request options to apply.
     *
     * @return PromiseInterface The `GuzzleHttp\Promise\PromiseInterface` instance
     */
    public function requestAsync(string $method, string $uri = '', array $options = []): PromiseInterface
    {
        $handler = new Pipeline(function (RequestInterface $request) use ($options) {
            return $this->getClient()->sendAsync($request, $options);
        }, $this->getMiddlewares());

        return $handler->handle(new Request($method, UriTemplate::expand($uri, $options)));
    }
}
