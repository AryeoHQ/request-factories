<?php

declare(strict_types=1);

namespace Support\Http\Requests\Factories\Testing\Concerns;

use Illuminate\Database\Eloquent\Factories\Sequence;
use PHPUnit\Framework\Attributes\Test;
use Tests\Fixtures;

/**
 * @mixin \Tests\TestCase
 */
trait NewTestCases
{
    #[Test]
    public function it_is_newable(): void
    {
        $this->assertInstanceOf(Fixtures\Support\Requests\Factory::class, Fixtures\Support\Requests\Factory::new());
    }

    #[Test]
    public function it_is_newable_with_attributes(): void
    {
        $note = 'Lorem ipsum.';

        $request = Fixtures\Support\Requests\Factory::new(['note' => $note])->make();

        $this->assertSame($note, $request->note);
    }

    #[Test]
    public function it_is_newable_with_closure(): void
    {
        $note = 'Lorem ipsum.';

        $request = Fixtures\Support\Requests\Factory::new([
            'full_name' => fn (array $attributes) => data_get($attributes, 'first_name').' '.data_get($attributes, 'last_name'),
            'note' => fn () => $note,
        ])->make();

        $this->assertSame('John Smith', $request->full_name);
        $this->assertSame($note, $request->note);
    }

    #[Test]
    public function it_is_newable_with_overrides(): void
    {
        $firstName = 'Jane';

        $request = Fixtures\Support\Requests\Factory::new(['first_name' => $firstName]);

        $this->assertSame($firstName, $request->make()->first_name);
    }

    #[Test]
    public function it_is_newable_with_sequence(): void
    {
        [$a, $b] = ['A', 'B'];

        $requests = Fixtures\Support\Requests\Factory::new(new Sequence(
            ['middle_initial' => $a],
            ['middle_initial' => $b],
        ))->count(2)->make();

        $this->assertSame($a, $requests->first()->middle_initial);
        $this->assertSame($b, $requests->last()->middle_initial);
    }
}
