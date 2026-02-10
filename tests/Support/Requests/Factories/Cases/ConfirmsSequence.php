<?php

declare(strict_types=1);

namespace Tests\Support\Requests\Factories\Cases;

use PHPUnit\Framework\Attributes\Test;
use Tests\Fixtures;

/**
 * @mixin \Tests\TestCase
 */
trait ConfirmsSequence
{
    #[Test]
    public function it_supports_sequence(): void
    {
        [$a, $b] = ['A', 'B'];

        /** @var \Illuminate\Support\Collection<int, Fixtures\Requests\Request> $requests */
        $requests = Fixtures\Requests\Factory::times(2)->sequence(
            ['middle_initial' => $a],
            ['middle_initial' => $b],
        )->make();

        $this->assertSame($a, $requests->first()->middle_initial);
        $this->assertSame($b, $requests->last()->middle_initial);
    }

    // foreachSequence
    #[Test]
    public function it_supports_foreach_sequence(): void
    {
        [$a, $b] = ['A', 'B'];

        $sequence = [
            ['middle_initial' => $a],
            ['middle_initial' => $b],
        ];
        /** @var \Illuminate\Support\Collection<int, Fixtures\Requests\Request> $requests */
        $requests = Fixtures\Requests\Factory::times(2)->forEachSequence(...$sequence)->make();

        $this->assertSame($a, $requests->first()->middle_initial);
        $this->assertSame($b, $requests->last()->middle_initial);
    }

    // crossJoinSequence
    #[Test]
    public function it_supports_cross_join_sequence(): void
    {
        [$a, $b] = ['A', 'B'];
        [$mr, $mrs] = ['Mr.', 'Mrs.'];

        $sequence = [[
            ['middle_initial' => $a, 'salutation' => $mr],
            ['middle_initial' => $b, 'salutation' => $mrs],
        ]];

        /** @var \Illuminate\Support\Collection<int, Fixtures\Requests\Request> $requests */
        $requests = Fixtures\Requests\Factory::times(4)->crossJoinSequence(
            ...$sequence
        )->make();

        tap($requests->get(0), function ($first) use ($a, $mr) {
            $this->assertSame($a, $first->middle_initial);
            $this->assertSame($mr, $first->salutation);
        });
        tap($requests->get(1), function ($second) use ($b, $mrs) {
            $this->assertSame($b, $second->middle_initial);
            $this->assertSame($mrs, $second->salutation);
        });
        tap($requests->get(2), function ($third) use ($a, $mr) {
            $this->assertSame($a, $third->middle_initial);
            $this->assertSame($mr, $third->salutation);
        });
        tap($requests->get(3), function ($fourth) use ($b, $mrs) {
            $this->assertSame($b, $fourth->middle_initial);
            $this->assertSame($mrs, $fourth->salutation);
        });
    }
}
