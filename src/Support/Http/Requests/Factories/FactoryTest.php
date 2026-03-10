<?php

declare(strict_types=1);

namespace Support\Http\Requests\Factories;

use PHPUnit\Framework\Attributes\Test;
use Tests\Fixtures;
use Tests\TestCase;

class FactoryTest extends TestCase
{
    use Testing\Concerns\CustomHelpersTestCases;
    use Testing\Concerns\FactoryDefinitionTestCases;
    use Testing\Concerns\MacroableTestCases;
    use Testing\Concerns\MakeTestCases;
    use Testing\Concerns\MultipleTestCases;
    use Testing\Concerns\NewTestCases;
    use Testing\Concerns\PrependStateTestCases;
    use Testing\Concerns\ProxyIntegrityTestCases;
    use Testing\Concerns\RecycleTestCases;
    use Testing\Concerns\SequenceTestCases;
    use Testing\Concerns\SetTestCases;
    use Testing\Concerns\StateTestCases;

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
