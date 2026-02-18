<?php

declare(strict_types=1);

namespace Tests\Support\Requests\Factories\Cases;

use PHPUnit\Framework\Attributes\Test;
use Tests\Fixtures;
use Tests\Fixtures\Support\Requests\RequestAttributeDefinedFactory;

/**
 * @mixin \Tests\TestCase
 */
trait ConfirmsFactoryDefinition
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
