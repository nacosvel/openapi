<?php

namespace Nacosvel\OpenAPI\Middleware;

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

    public function handle(RequestInterface $request, callable $next): PromiseInterface
    {
        return $next($request)->then(function (ResponseInterface $response) {
            return $response;
        });
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
