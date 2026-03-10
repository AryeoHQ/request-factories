<?php

declare(strict_types=1);

namespace Support\Http\Requests\Factories\Testing\Concerns;

use Illuminate\Database\Eloquent\Factories\Sequence;
use PHPUnit\Framework\Attributes\Test;
use Tests\Fixtures;

/**
 * @mixin \Tests\TestCase
 */
trait StateTestCases
{
    #[Test]
    public function it_receives_state(): void
    {
        $note = 'Lorem ipsum.';
        $request = Fixtures\Support\Requests\Factory::new()->state(['note' => $note])->make();

        $this->assertSame($note, $request->note);
    }

    #[Test]
    public function it_receives_state_with_closure(): void
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
    public function it_receives_state_with_overrides(): void
    {
        $firstName = 'Jane';

        $request = Fixtures\Support\Requests\Factory::new()->state(['first_name' => $firstName])->make();

        $this->assertSame($firstName, $request->first_name);
    }

    #[Test]
    public function it_receives_state_with_sequence(): void
    {
        [$a, $b] = ['A', 'B'];

        $requests = Fixtures\Support\Requests\Factory::times(2)->state(new Sequence(
            ['middle_initial' => $a],
            ['middle_initial' => $b],
        ))->make();

        $this->assertSame($a, $requests->first()->middle_initial);
        $this->assertSame($b, $requests->last()->middle_initial);
    }

    #[Test]
    public function it_overrides_new_with_state(): void
    {
        $note = 'Lorem ipsum dolor sit amet.';

        $request = Fixtures\Support\Requests\Factory::new(['note' => 'Lorem ipsum.'])->state(['note' => $note])->make();

        $this->assertSame($note, $request->note);
    }

    #[Test]
    public function it_overrides_helper_state_with_state(): void
    {
        $role = 'user';

        $request = Fixtures\Support\Requests\Factory::new()->admin()->state(['role' => $role])->make();

        $this->assertSame($role, $request->role);
    }

    #[Test]
    public function it_overrides_prepended_with_state(): void
    {
        $firstName = 'Jane';

        $request = Fixtures\Support\Requests\Factory::new()->prependState(['first_name' => 'Joe'])->state(['first_name' => $firstName])->make();

        $this->assertSame($firstName, $request->first_name);
    }
}
