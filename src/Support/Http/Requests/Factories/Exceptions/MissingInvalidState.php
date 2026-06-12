<?php

declare(strict_types=1);

namespace Support\Http\Requests\Factories\Exceptions;

use Illuminate\Support\Stringable;
use LogicException;
use Support\Http\Requests\Factories\Attributes\Invalid;
use Support\Http\Requests\Factories\Factory;

class MissingInvalidState extends LogicException
{
    private Stringable $template { get => str('No methods with the #[%s] are defined on [%s].'); }

    /** @param Factory<\Illuminate\Http\Request> $factory */
    public function __construct(Factory $factory)
    {
        parent::__construct(
            $this->template->replaceArray('%s', [class_basename(Invalid::class), $factory::class])->toString()
        );
    }
}
