<?php

declare(strict_types=1);

namespace Tests\Fixtures\Requests;

/**
 * @extends \Support\Http\Requests\Factories\Factory<Request>
 *
 * @method static guest()
 */
class Factory extends \Support\Http\Requests\Factories\Factory
{
    protected string $request = Request::class;

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

    public function admin(): static
    {
        return $this->state(['role' => 'admin']);
    }
}
