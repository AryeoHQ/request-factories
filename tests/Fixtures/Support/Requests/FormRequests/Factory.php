<?php

declare(strict_types=1);

namespace Tests\Fixtures\Support\Requests\FormRequests;

/**
 * @extends \Support\Http\Requests\Factories\Factory<FormRequest>
 *
 * @method static middleName()
 */
class Factory extends \Support\Http\Requests\Factories\Factory
{
    protected string $request = FormRequest::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => 'John',
            'last_name' => fn () => 'Smith',
        ];
    }

    public function middleName(): static
    {
        return $this->state(function (): array {
            return [
                'middle_name' => 'Quincy',
            ];
        });
    }
}
