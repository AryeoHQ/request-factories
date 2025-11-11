<?php

declare(strict_types=1);

namespace Tests\Support\Requests\Factories\Cases;

use Illuminate\Database\Eloquent\Factories\Sequence;
use PHPUnit\Framework\Attributes\Test;
use Tests\Fixtures;

/**
 * @mixin \Tests\TestCase
 */
trait ConfirmsMake
{
    #[Test]
    public function it_makes(): void
    {
        $this->assertInstanceOf(
            Fixtures\Requests\Request::class,
            Fixtures\Requests\Factory::new()->make(),
        );
    }

    #[Test]
    public function it_makes_with_attributes(): void
    {
        $note = 'Lorem ipsum.';

        $request = Fixtures\Requests\Factory::new()->make(['note' => $note]);

        $this->assertSame($note, $request->note);
    }

    #[Test]
    public function it_makes_with_closure(): void
    {
        $note = 'Lorem ipsum.';

        $request = Fixtures\Requests\Factory::new([
            'full_name' => fn (array $attributes) => data_get($attributes, 'first_name').' '.data_get($attributes, 'last_name'),
            'note' => fn () => $note,
        ])->make();

        $this->assertSame('John Smith', $request->full_name);
        $this->assertSame($note, $request->note);
    }

    #[Test]
    public function it_makes_with_overrides(): void
    {
        $firstName = 'Jane';

        $request = Fixtures\Requests\Factory::new()->make(['first_name' => $firstName]);

        $this->assertSame($firstName, $request->first_name);
    }

    #[Test]
    public function it_makes_with_sequence(): void
    {
        [$a, $b] = ['A', 'B'];

        $requests = Fixtures\Requests\Factory::times(2)->make(new Sequence(
            ['middle_initial' => $a],
            ['middle_initial' => $b],
        ));

        $this->assertSame($a, $requests->first()->middle_initial);
        $this->assertSame($b, $requests->last()->middle_initial);
    }

    #[Test]
    public function it_overrides_state_with_make(): void
    {
        $note = 'Lorem ipsum dolor sit amet.';

        $request = Fixtures\Requests\Factory::new()->state(['note' => 'Lorem ipsum.'])->make(['note' => $note]);

        $this->assertSame($note, $request->note);
    }

    #[Test]
    public function it_overrides_helper_state_with_make(): void
    {
        $role = 'user';

        $request = Fixtures\Requests\Factory::new()->admin()->make(['role' => $role]);

        $this->assertSame($role, $request->role);
    }
}
