<?php

declare(strict_types=1);

namespace Tests\Support\Requests\Factories\Cases;

use PHPUnit\Framework\Attributes\Test;
use Tests\Fixtures;

/**
 * @mixin \Tests\TestCase
 */
trait ConfirmsMultiple
{
    #[Test]
    public function it_supports_times(): void
    {
        $requests = Fixtures\Requests\Factory::times(3)->make();

        $this->assertCount(3, $requests);
        $this->assertContainsOnlyInstancesOf(Fixtures\Requests\Request::class, $requests);
    }

    #[Test]
    public function it_supports_count(): void
    {
        $requests = Fixtures\Requests\Factory::new()->count(3)->make();

        $this->assertCount(3, $requests);
        $this->assertContainsOnlyInstancesOf(Fixtures\Requests\Request::class, $requests);
    }
}
