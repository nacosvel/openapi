<?php

namespace Nacosvel\OpenAPI\Contracts;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;

interface Chainable
{
    /**
     * @return ClientDecorator The `ClientDecorator` instance
     */
    public function getClientDecorator(): ClientDecorator;

    /**
     * @return ClientInterface
     */
    public function getClient(): ClientInterface;

    /**
     * @return HandlerStack
     */
    public function getClientHandlerStack(): HandlerStack;

    /**
     * @param array|MiddlewareInterface $middleware
     *
     * @return static
     */
    public function addMiddleware(array|MiddlewareInterface $middleware): static;

    /**
     * Get all middlewares
     *
     * @return array
     */
    public function getMiddlewares(): array;

    /**
     * @param string $uri
     * @param array  $options
     *
     * @return Selector
     */
    public function select(string $uri, array $options = []): Selector;

    /**
     * Chainable the given `$segment` with the `ClientDecorator` instance
     *
     * @param string $segment - The segment or `URI`
     */
    public function chain(string $segment): Chainable;

    /**
     * URI pathname
     *
     * @param string $separator The URI separator, default is slash(`/`) character
     *
     * @return string The URI string
     */
    public function pathname(string $separator = '/'): string;

    /**
     * Create and send an HTTP GET request.
     *
     * @param array<string,string|int|bool|array|mixed> $options Request options to apply.
     */
    public function get(array $options = []): ResponseInterface;

    /**
     * Create and send an HTTP PUT request.
     *
     * @param array<string,string|int|bool|array|mixed> $options Request options to apply.
     */
    public function put(array $options = []): ResponseInterface;

    /**
     * Create and send an HTTP POST request.
     *
     * @param array<string,string|int|bool|array|mixed> $options Request options to apply.
     */
    public function post(array $options = []): ResponseInterface;

    /**
     * Create and send an HTTP PATCH request.
     *
     * @param array<string,string|int|bool|array|mixed> $options Request options to apply.
     */
    public function patch(array $options = []): ResponseInterface;

    /**
     * Create and send an HTTP DELETE request.
     *
     * @param array<string,string|int|bool|array|mixed> $options Request options to apply.
     */
    public function delete(array $options = []): ResponseInterface;

    /**
     * Create and send an asynchronous HTTP GET request.
     *
     * @param array<string,string|int|bool|array|mixed> $options Request options to apply.
     */
    public function getAsync(array $options = []): PromiseInterface;

    /**
     * Create and send an asynchronous HTTP PUT request.
     *
     * @param array<string,string|int|bool|array|mixed> $options Request options to apply.
     */
    public function putAsync(array $options = []): PromiseInterface;

    /**
     * Create and send an asynchronous HTTP POST request.
     *
     * @param array<string,string|int|bool|array|mixed> $options Request options to apply.
     */
    public function postAsync(array $options = []): PromiseInterface;

    /**
     * Create and send an asynchronous HTTP PATCH request.
     *
     * @param array<string,string|int|bool|array|mixed> $options Request options to apply.
     */
    public function patchAsync(array $options = []): PromiseInterface;

    /**
     * Create and send an asynchronous HTTP DELETE request.
     *
     * @param array<string,string|int|bool|array|mixed> $options Request options to apply.
     */
    public function deleteAsync(array $options = []): PromiseInterface;
}
