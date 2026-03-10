<?php

declare(strict_types=1);

namespace Support\Http\Requests\Factories\Testing\Concerns;

use Closure;
use PHPUnit\Framework\Attributes\Test;
use Tests\Fixtures;

/**
 * @mixin \Tests\TestCase
 */
trait MacroableTestCases
{
    #[Test]
    public function it_can_register_macros(): void
    {
        $role = 'guest';
        Fixtures\Support\Requests\Factory::macro('guest', fn (): static => $this->state(['role' => $role])); // @phpstan-ignore-line

        $request = Fixtures\Support\Requests\Factory::new()->guest()->make();

        $this->assertSame($role, $request->role);
    }

    #[Test]
    public function it_can_register_mixin(): void
    {
        Fixtures\Support\Requests\Factory::mixin(new Guest);

        $request = Fixtures\Support\Requests\Factory::new()->guest()->make();

        $this->assertSame('guest', $request->role);
    }
}

class Guest
{
    public function guest(): Closure
    {
        return fn (): static => $this->state(['role' => 'guest']); // @phpstan-ignore-line
    }
}
