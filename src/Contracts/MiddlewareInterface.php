<?php

namespace Nacosvel\OpenAPI\Contracts;

use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface MiddlewareInterface
{
    /**
     * @param RequestInterface $request
     * @param callable         $next
     *
     * @return PromiseInterface<ResponseInterface>
     */
    public function handle(RequestInterface $request, callable $next): PromiseInterface;
}
