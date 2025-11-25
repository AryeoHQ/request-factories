<?php

declare(strict_types=1);

namespace Tests\Support\Requests;

use PHPUnit\Framework\Attributes\Test;
use Support\Http\Requests\Exceptions\NotSupported;
use Tests\Fixtures;

class RequestTest extends \Tests\TestCase
{
    #[Test]
    public function it_interacts_with_factory(): void
    {
        $this->assertInstanceOf(
            Fixtures\Requests\Factory::class,
            Fixtures\Requests\Request::factory(),
        );
    }

    #[Test]
    public function it_throws_exception_when_retrieving_validated_data(): void
    {
        $this->expectException(NotSupported::class);

        $request = Fixtures\Requests\Request::factory()->make();

        $request->validated('first_name');
    }

    #[Test]
    public function it_throws_exception_when_retrieving_safe_data(): void
    {
        $this->expectException(NotSupported::class);

        $request = Fixtures\Requests\Request::factory()->make();

        $request->safe()->only('first_name');
    }
}
