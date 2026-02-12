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
        protected array $middlewares = [],
    ) {
        //
    }

    /**
     * @param MiddlewareInterface $middleware
     *
     * @return static
     */
    public function pipe(MiddlewareInterface $middleware): static
    {
        $this->middlewares[] = $middleware;

        return $this;
    }

    /**
     * @param RequestInterface $request
     * @param array            $options
     * @param callable         $passable
     *
     * @return PromiseInterface
     */
    public function handle(RequestInterface $request, array $options, callable $passable): PromiseInterface
    {
        $handler = array_reduce(array_reverse($this->middlewares), function ($next, MiddlewareInterface $middleware): Closure {
            return function ($request, $options) use ($next, $middleware) {
                $response = $middleware->handle($request, $options, $next);
                return $response instanceof PromiseInterface ? $response : Create::promiseFor($response);
            };
        }, $passable);

        $response = $handler($request, $options);

        return $response instanceof PromiseInterface ? $response : Create::promiseFor($response);
    }
}
