<?php

declare(strict_types=1);

namespace Tests\Support\Requests\Factories;

use PHPUnit\Framework\Attributes\Test;
use Tests\Fixtures;
use Tests\TestCase;

class FactoryTest extends TestCase
{
    use Cases\ConfirmsCustomHelpers;
    use Cases\ConfirmsFactoryDefinition;
    use Cases\ConfirmsMacroable;
    use Cases\ConfirmsMake;
    use Cases\ConfirmsMultiple;
    use Cases\ConfirmsNew;
    use Cases\ConfirmsPrependState;
    use Cases\ConfirmsProxyIntegrity;
    use Cases\ConfirmsRecycle;
    use Cases\ConfirmsSequence;
    use Cases\ConfirmsSet;
    use Cases\ConfirmsState;

    #[Test]
    public function it_uses_definition(): void
    {
        $request = Fixtures\Support\Requests\Factory::new()->make();

        $this->assertSame('John', $request->first_name);
        $this->assertSame('Smith', $request->last_name);
    }

    #[Test]
    public function it_handles_model_factories(): void
    {
        $request = Fixtures\Support\Requests\Factory::new()->state([
            'website_id' => Fixtures\Support\Models\Website::factory(),
        ])->make();

        $this->assertSame(
            Fixtures\Support\Models\Website::first()->getKey(),
            $request->website_id
        );
    }
}
