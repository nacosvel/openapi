<?php

namespace Nacosvel\OpenAPI\Contracts;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;

interface ClientDecorator
{
    /**
     * @param array $config
     *
     * @return static
     */
    public function config(array $config = []): static;

    /**
     * @param string|null $key
     * @param mixed|null  $default
     *
     * @return mixed
     */
    public function getConfig(string $key = null, mixed $default = null): mixed;

    /**
     * @param array $options
     *
     * @return static
     */
    public function options(array $options = []): static;

    /**
     * @param string|null $key
     * @param mixed|null  $default
     *
     * @return mixed
     */
    public function option(string $key = null, mixed $default = null): mixed;

    /**
     * @return array
     */
    public function getOptions(): array;

    /**
     * @return ClientInterface
     */
    public function getClient(): ClientInterface;

    /**
     * @param ClientInterface $client
     *
     * @return ClientDecorator
     */
    public function setClient(ClientInterface $client): ClientDecorator;

    /**
     * @return static
     */
    public function flushMiddleware(): static;

    /**
     * @param array|MiddlewareInterface $middleware
     *
     * @return static
     */
    public function addMiddleware(array|MiddlewareInterface $middleware): static;

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
    public function request(string $method, string $uri = '', array $options = []): ResponseInterface;

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
    public function requestAsync(string $method, string $uri = '', array $options = []): PromiseInterface;
}
