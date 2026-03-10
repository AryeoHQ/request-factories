<?php

declare(strict_types=1);

namespace Support\Http\Requests\Factories\Testing\Concerns;

use PHPUnit\Framework\Attributes\Test;
use Support\Http\Requests\Factories\Factory;
use Tests\Fixtures;

/**
 * @mixin \Tests\TestCase
 */
trait ProxyIntegrityTestCases
{
    #[Test]
    public function it_gracefully_proxies_definition(): void
    {
        $a = ProxyIntegrityA::new()->make();
        $b = ProxyIntegrityB::new()->make();
        $c = ProxyIntegrityC::new()->make();

        tap(
            ProxyIntegrityA::new()->make(),
            fn (Fixtures\Support\Requests\Request $request) => $this->assertSame('John Smith', $request->full_name)
        );

        tap(
            ProxyIntegrityB::new()->make(),
            fn (Fixtures\Support\Requests\Request $request) => $this->assertSame('Jane Doe', $request->full_name)
        );

        tap(
            ProxyIntegrityC::new()->make(),
            fn (Fixtures\Support\Requests\Request $request) => $this->assertSame('Joe Johnson', $request->full_name)
        );
    }
}

/**
 * @extends \Support\Http\Requests\Factories\Factory<Fixtures\Support\Requests\Request>
 */
class ProxyIntegrityA extends Factory
{
    protected string $request = Fixtures\Support\Requests\Request::class;

    public function definition(): array
    {
        return [
            'first_name' => 'John',
            'last_name' => 'Smith',
            'full_name' => fn (array $attributes) => data_get($attributes, 'first_name').' '.data_get($attributes, 'last_name'),
        ];
    }
}

/**
 * @extends \Support\Http\Requests\Factories\Factory<Fixtures\Support\Requests\Request>
 */
class ProxyIntegrityB extends Factory
{
    protected string $request = Fixtures\Support\Requests\Request::class;

    public function definition(): array
    {
        return [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'full_name' => fn (array $attributes) => data_get($attributes, 'first_name').' '.data_get($attributes, 'last_name'),
        ];
    }
}

/**
 * @extends \Support\Http\Requests\Factories\Factory<Fixtures\Support\Requests\Request>
 */
class ProxyIntegrityC extends Factory
{
    protected string $request = Fixtures\Support\Requests\Request::class;

    public function definition(): array
    {
        return [
            'first_name' => 'Joe',
            'last_name' => 'Johnson',
            'full_name' => fn (array $attributes) => data_get($attributes, 'first_name').' '.data_get($attributes, 'last_name'),
        ];
    }
}
