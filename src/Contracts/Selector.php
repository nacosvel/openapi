<?php

namespace Nacosvel\OpenAPI\Contracts;

interface Selector
{
    public function client(): ClientDecorator;

    public function pathname(): string;
}
