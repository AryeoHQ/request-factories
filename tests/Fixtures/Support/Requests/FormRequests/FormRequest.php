<?php

declare(strict_types=1);

namespace Tests\Fixtures\Support\Requests\FormRequests;

use Support\Http\Requests\Factories\Attributes\UseFactory;
use Support\Http\Requests\Factories\Provides\HasFactory;

#[UseFactory(Factory::class)]
class FormRequest extends \Illuminate\Foundation\Http\FormRequest
{
    /** @use HasFactory<Factory> */
    use HasFactory;

    /** @return array<array-key, mixed> */
    public function rules(): array
    {
        return [
            'middle_name' => ['required'],
        ];
    }
}
