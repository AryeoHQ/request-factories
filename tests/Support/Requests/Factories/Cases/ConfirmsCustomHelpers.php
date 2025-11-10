<?php

declare(strict_types=1);

namespace Tests\Support\Requests\Factories\Cases;

use PHPUnit\Framework\Attributes\Test;
use Tests\Fixtures;

/**
 * @mixin \Tests\TestCase
 */
trait ConfirmsCustomHelpers
{
    #[Test]
    public function it_applies_helper_states(): void
    {
        $request = Fixtures\Requests\Factory::new()->admin()->make();

        $this->assertSame('admin', $request->role);
    }

    #[Test]
    public function it_overrides_new_with_helper_state(): void
    {
        $request = Fixtures\Requests\Factory::new(['role' => 'user'])->admin()->make();

        $this->assertSame('admin', $request->role);
    }
}
