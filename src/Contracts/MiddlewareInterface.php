<?php

namespace Nacosvel\OpenAPI\Contracts;

use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface MiddlewareInterface
{
    /**
     * @param RequestInterface $request
     * @param array            $options
     * @param callable         $next
     *
     * @return PromiseInterface|ResponseInterface
     */
    public function handle(RequestInterface $request, array $options, callable $next): PromiseInterface|ResponseInterface;
}
