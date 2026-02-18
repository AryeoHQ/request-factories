<?php

declare(strict_types=1);

namespace Tests\Support\Requests\Factories\Cases;

use PHPUnit\Framework\Attributes\Test;
use Tests\Fixtures;

/**
 * @mixin \Tests\TestCase
 */
trait ConfirmsSet
{
    #[Test]
    public function it_can_set(): void
    {
        $note = 'Lorem ipsum.';

        $request = Fixtures\Support\Requests\Factory::new()->set('note', $note)->make();

        $this->assertSame($note, $request->note);
    }

    #[Test]
    public function it_can_set_with_closure(): void
    {
        $note = 'Lorem ipsum.';

        $request = Fixtures\Support\Requests\Factory::new()->set(
            'note',
            fn () => $note
        )->set(
            'full_name',
            fn (array $attributes) => data_get($attributes, 'first_name').' '.data_get($attributes, 'last_name'),
        )->make();

        $this->assertSame($note, $request->note);
        $this->assertSame('John Smith', $request->full_name);
    }

    #[Test]
    public function it_overrides_with_set(): void
    {
        $firstName = 'Jane';

        $request = Fixtures\Support\Requests\Factory::new()->set('first_name', $firstName)->make();

        $this->assertSame($firstName, $request->first_name);
    }
}
