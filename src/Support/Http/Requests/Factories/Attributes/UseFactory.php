<?php

declare(strict_types=1);

namespace Support\Http\Requests\Factories\Attributes;

use Attribute;
use Support\Http\Requests\Factories\Factory;

/**
 * @template TRequest of \Illuminate\Http\Request
 */
#[Attribute(Attribute::TARGET_CLASS)]
class UseFactory
{
    /**
     * Create a new attribute instance.
     *
     * @param  class-string<Factory<TRequest>>  $factoryClass
     */
    public function __construct(public string $factoryClass) {}
}
