<?php

declare(strict_types=1);

namespace Support\Http\Requests\Factories\Testing\Concerns;

use PHPUnit\Framework\Attributes\Test;
use Support\Http\Requests\Factories\Exceptions\MissingInvalidState;
use Tests\Fixtures;

/**
 * @mixin \Tests\TestCase
 */
trait CustomHelpersTestCases
{
    #[Test]
    public function it_applies_helper_states(): void
    {
        $request = Fixtures\Support\Requests\Factory::new()->admin()->make();

        $this->assertSame('admin', $request->role);
    }

    #[Test]
    public function it_overrides_new_with_helper_state(): void
    {
        $request = Fixtures\Support\Requests\Factory::new(['role' => 'user'])->admin()->make();

        $this->assertSame('admin', $request->role);
    }

    #[Test]
    public function it_applies_an_invalid_state(): void
    {
        $request = Fixtures\Support\Requests\Factory::new()->invalid()->make();

        $this->assertNull($request->first_name);
    }

    #[Test]
    public function it_throws_when_no_invalid_states_are_defined(): void
    {
        $this->expectException(MissingInvalidState::class);

        Fixtures\Support\Requests\FactoryWithoutInvalidStates::new()->invalid();
    }
}
