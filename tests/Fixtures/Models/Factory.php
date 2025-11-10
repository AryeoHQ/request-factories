<?php

declare(strict_types=1);

namespace Tests\Fixtures\Models;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Website>
 */
class Factory extends \Illuminate\Database\Eloquent\Factories\Factory
{
    protected $model = Website::class;

    public function definition(): array
    {
        return [
            'domain' => fake()->domainName(),
            'tld' => fake()->tld(),
        ];
    }
}
