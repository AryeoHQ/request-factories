<?php

declare(strict_types=1);

namespace Tests\Fixtures\Requests;

use Support\Http\Requests\Factories\Attributes\UseFactory;
use Support\Http\Requests\Factories\Provides\HasFactory;

#[UseFactory(Factory::class)]
class RequestAttributeDefinedFactory extends \Illuminate\Http\Request
{
    /** @use HasFactory<Factory> */
    use HasFactory;
}
