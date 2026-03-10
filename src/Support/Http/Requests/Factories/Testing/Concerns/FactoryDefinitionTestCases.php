<?php

declare(strict_types=1);

namespace Support\Http\Requests\Factories\Testing\Concerns;

use PHPUnit\Framework\Attributes\Test;
use Tests\Fixtures;
use Tests\Fixtures\Support\Requests\RequestAttributeDefinedFactory;

/**
 * @mixin \Tests\TestCase
 */
trait FactoryDefinitionTestCases
{
    #[Test]
    public function it_can_define_factory_with_attribute(): void
    {
        $this->assertInstanceOf(
            Fixtures\Support\Requests\Factory::class,
            RequestAttributeDefinedFactory::factory()
        );
    }
}
