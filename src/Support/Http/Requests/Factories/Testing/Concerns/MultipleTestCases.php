<?php

declare(strict_types=1);

namespace Support\Http\Requests\Factories\Testing\Concerns;

use PHPUnit\Framework\Attributes\Test;
use Tests\Fixtures;

/**
 * @mixin \Tests\TestCase
 */
trait MultipleTestCases
{
    #[Test]
    public function it_supports_times(): void
    {
        $requests = Fixtures\Support\Requests\Factory::times(3)->make();

        $this->assertCount(3, $requests);
        $this->assertContainsOnlyInstancesOf(Fixtures\Support\Requests\Request::class, $requests);
    }

    #[Test]
    public function it_supports_count(): void
    {
        $requests = Fixtures\Support\Requests\Factory::new()->count(3)->make();

        $this->assertCount(3, $requests);
        $this->assertContainsOnlyInstancesOf(Fixtures\Support\Requests\Request::class, $requests);
    }
}
