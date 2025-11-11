<?php

declare(strict_types=1);

namespace Support\Http\Requests\Factories\Provides;

use Illuminate\Database\Eloquent\Model;
use Support\Http\Requests\Factories\Attributes\UseFactory;
use Support\Http\Requests\Factories\Factory;

/**
 * @template TFactory of Factory
 */
trait HasFactory
{
    /**
     * @param  (callable(array<string, mixed>, Model|null): array<string, mixed>)|array<string, mixed>  $state
     * @return TFactory
     */
    public static function factory(callable|array $state = []): Factory
    {
        $factory = static::newFactory();

        return $factory->state($state);
    }

    /**
     * @return null|TFactory
     */
    protected static function newFactory(): null|Factory
    {
        return static::getUseFactoryAttribute();
    }

    /**
     * @return null|TFactory
     */
    protected static function getUseFactoryAttribute(): null|Factory
    {
        $attributes = (new \ReflectionClass(static::class))->getAttributes(UseFactory::class);

        if ($attributes !== []) {
            $useFactory = $attributes[0]->newInstance();

            return $useFactory->factoryClass::new(); // @phpstan-ignore-line
        }

        return null;
    }
}
