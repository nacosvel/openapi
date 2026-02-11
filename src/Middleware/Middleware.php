<?php

namespace Nacosvel\OpenAPI\Middleware;

use GuzzleHttp\Promise\Create;
use GuzzleHttp\Promise\PromiseInterface;
use Nacosvel\OpenAPI\Contracts\MiddlewareInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Middleware implements MiddlewareInterface
{
    public function __construct(
        protected array $config = [],
    ) {
        //
    }

    public function handle(RequestInterface $request, array $options, callable $next): PromiseInterface|ResponseInterface
    {
        $response = $next($request, $options);
        $response = $response instanceof ResponseInterface ? Create::promiseFor($response) : $response;
        return $response->then(fn(ResponseInterface $response) => $response);
    }

    public function prepare(string $uri, array $options = []): bool
    {
        return true;
    }

    public function expand(string $uri): string
    {
        return $uri;
    }
}
