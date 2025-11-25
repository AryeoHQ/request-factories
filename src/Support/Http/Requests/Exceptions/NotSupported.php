<?php

declare(strict_types=1);

namespace Support\Http\Requests\Exceptions;

use BadMethodCallException;

class NotSupported extends BadMethodCallException
{
    public function __construct(string $method)
    {
        parent::__construct("The method [{$method}] is only supported on [FormRequest].");
    }
}
