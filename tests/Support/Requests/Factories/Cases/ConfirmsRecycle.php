<?php

declare(strict_types=1);

namespace Tests\Support\Requests\Factories\Cases;

use PHPUnit\Framework\Attributes\Test;
use Tests\Fixtures;

/**
 * @mixin \Tests\TestCase
 */
trait ConfirmsRecycle
{
    #[Test]
    public function it_supports_recycle(): void
    {
        $website = Fixtures\Support\Models\Website::factory()->create();

        $requests = Fixtures\Support\Requests\Factory::times(2)->state([
            'website_id' => fn () => Fixtures\Support\Models\Website::factory(),
        ])->recycle($website)->make();

        $this->assertCount(1, Fixtures\Support\Models\Website::all());
        $this->assertSame($website->getKey(), $requests->first()->website_id);
        $this->assertSame($website->getKey(), $requests->last()->website_id);
    }
}
