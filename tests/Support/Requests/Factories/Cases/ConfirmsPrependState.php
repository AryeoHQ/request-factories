<?php

declare(strict_types=1);

namespace Tests\Support\Requests\Factories\Cases;

use Illuminate\Database\Eloquent\Factories\Sequence;
use PHPUnit\Framework\Attributes\Test;
use Tests\Fixtures;

/**
 * @mixin \Tests\TestCase
 */
trait ConfirmsPrependState
{
    #[Test]
    public function it_receives_prepended_state(): void
    {
        $note = 'Lorem ipsum.';

        $request = Fixtures\Requests\Factory::new()->prependState(['note' => $note])->make();

        $this->assertSame($note, $request->note);
    }

    #[Test]
    public function it_receives_prepended_state_with_closure(): void
    {
        $note = 'Lorem ipsum.';

        $request = Fixtures\Requests\Factory::new()->prependState([
            'full_name' => fn (array $attributes) => data_get($attributes, 'first_name').' '.data_get($attributes, 'last_name'),
            'note' => fn () => $note,
        ])->make();

        $this->assertSame('John Smith', $request->full_name);
        $this->assertSame($note, $request->note);
    }

    #[Test]
    public function it_receives_prepended_state_with_overrides(): void
    {
        $firstName = 'Jane';

        $request = Fixtures\Requests\Factory::new()->prependState(['first_name' => $firstName])->make();

        $this->assertSame($firstName, $request->first_name);
    }

    #[Test]
    public function it_receives_prepended_state_with_sequence(): void
    {
        [$a, $b] = ['A', 'B'];

        $requests = Fixtures\Requests\Factory::times(2)->prependState(new Sequence(
            ['middle_initial' => $a],
            ['middle_initial' => $b],
        ))->make();

        $this->assertSame($a, $requests->first()->middle_initial);
        $this->assertSame($b, $requests->last()->middle_initial);
    }
}
