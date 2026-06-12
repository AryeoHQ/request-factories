<?php

declare(strict_types=1);

namespace Tests\Fixtures\Support\Requests;

/**
 * @extends \Support\Http\Requests\Factories\Factory<Request>
 */
class FactoryWithoutInvalidStates extends \Support\Http\Requests\Factories\Factory
{
    protected string $request = Request::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => 'John',
            'last_name' => 'Smith',
        ];
    }
}
