<?php

declare(strict_types=1);

namespace Support\Http\Requests\Factories\Testing\Concerns;

use PHPUnit\Framework\Attributes\Test;
use Tests\Fixtures;

/**
 * @mixin \Tests\TestCase
 */
trait WithFilterTestCases
{
    #[Test]
    public function it_chains_filter_states(): void
    {
        $request = Fixtures\Support\Requests\Factory::new()
            ->withFilter('status', 'active')
            ->withFilter('role', 'admin')
            ->make();

        $this->assertSame([
            'status' => 'active',
            'role' => 'admin',
        ], $request->filters);
    }
}
