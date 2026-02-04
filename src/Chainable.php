<?php

namespace Nacosvel\OpenAPI;

use ArrayIterator;
use Nacosvel\OpenAPI\Concerns\HasChainable;

class Chainable extends ArrayIterator implements Contracts\Chainable
{
    use HasChainable;

    public function __construct(
        protected array $input,
        protected Contracts\ClientDecorator $decorator,
    ) {
        parent::__construct($input, self::STD_PROP_LIST | self::ARRAY_AS_PROPS);
    }

    /**
     * Only retrieve a copy array of the URI segments
     *
     * @return array The URI segments array
     */
    protected function allChains(): array
    {
        return array_filter($this->getArrayCopy(), static fn($value) => !($value instanceof Contracts\Chainable));
    }

    /**
     * Normalize the $subject by the rules:
     *```
     * PascalCase -> camelCase & camelCase -> kebab-case & _placeholder_ -> {placeholder}
     *```
     *
     * @param string $subject The string waiting for normalization
     *
     * @return string
     */
    protected function normalize(string $subject = ''): string
    {
        return preg_replace_callback_array([
            '#^[A-Z]#'   => static fn(array $match) => strtolower($match[0]),
            '#[A-Z]#'    => static fn(array $match) => strtolower("-{$match[0]}"),
            '#^_(.*)_$#' => static fn(array $match) => "{{$match[1]}}",
        ], $subject) ?? $subject;
    }

    /**
     * Get value for an offset
     *
     * @param mixed $key The offset to get the value from.
     *
     * @return Contracts\Chainable
     */
    public function offsetGet(mixed $key): Contracts\Chainable
    {
        if (!$this->offsetExists($key)) {
            $chains    = $this->allChains();
            $chains[]  = $this->normalize($key);
            $chainable = new self($chains, $this->getClientDecorator());
            $this->offsetSet($key, $chainable->addMiddleware($this->getMiddlewares()));
        }

        return parent::offsetGet($key);
    }

    /**
     * Chainable the given $segments with the ChainableInterface instance
     *
     * @param string $segments The segments or `URI`
     *
     * @return Contracts\Chainable
     */
    public function chain(string $segments): Contracts\Chainable
    {
        return $this->offsetGet($segments);
    }

    /**
     * URI pathname
     *
     * @param string $separator The URI separator, default is slash(`/`) character
     *
     * @return string The URI string
     */
    public function pathname(string $separator = '/'): string
    {
        return implode($separator, $this->allChains());
    }
}
