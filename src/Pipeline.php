<?php

namespace Nacosvel\OpenAPI;

use Closure;
use GuzzleHttp\Promise\Create;
use GuzzleHttp\Promise\PromiseInterface;
use Nacosvel\OpenAPI\Contracts\MiddlewareInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Pipeline
{
    public function __construct(
        protected Closure $passable,
        protected array $middlewares = [],
    ) {
        $this->passable = Closure::fromCallable($passable);
    }

    /**
     * @param MiddlewareInterface $middleware
     *
     * @return static
     */
    public function addMiddleware(MiddlewareInterface $middleware): static
    {
        $this->middlewares[] = $middleware;

        return $this;
    }

    /**
     * @param RequestInterface $request
     *
     * @return PromiseInterface
     */
    public function handle(RequestInterface $request): PromiseInterface
    {
        $passable = function ($passable) {
            return function (RequestInterface $request) use ($passable): PromiseInterface {
                $response = $passable($request);
                return $response instanceof ResponseInterface ? Create::promiseFor($response) : $response;
            };
        };

        $next = $passable($this->passable);

        foreach (array_reverse($this->middlewares) as $middleware) {
            $next = function (RequestInterface $request) use ($middleware, $next): PromiseInterface {
                $response = call_user_func([$middleware, 'handle'], $request, $next);
                return $response instanceof ResponseInterface ? Create::promiseFor($response) : $response;
            };
        }

        return $next($request);
    }
}
