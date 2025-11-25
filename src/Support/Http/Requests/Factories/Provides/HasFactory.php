<?php

declare(strict_types=1);

namespace Support\Http\Requests\Factories\Provides;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\ValidatedInput;
use Support\Http\Requests\Exceptions\NotSupported;
use Support\Http\Requests\Factories\Attributes\UseFactory;
use Support\Http\Requests\Factories\Factory;

/**
 * @template TFactory of Factory
 *
 * @mixin \Illuminate\Foundation\Http\FormRequest
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

    /**
     * @param  array<array-key, mixed>|int|string|null  $key
     * @param  mixed  $default
     *
     * @phpstan-return ($key is null ? array<string, mixed> : mixed)
     */
    public function validated($key = null, $default = null): mixed
    {
        throw_unless($this instanceof FormRequest, NotSupported::class, __METHOD__);

        $this->validateIfNotValidated();

        return parent::validated($key, $default); // @phpstan-ignore-line
    }

    /**
     * @param  array<array-key, mixed>|null  $keys
     *
     * @phpstan-return ($keys is null ? ValidatedInput : array<string, mixed>)
     */
    public function safe(null|array $keys = null): ValidatedInput|array
    {
        throw_unless($this instanceof FormRequest, NotSupported::class, __METHOD__);

        $this->validateIfNotValidated();

        return parent::safe($keys); // @phpstan-ignore-line
    }

    private function validateIfNotValidated(): void
    {
        if (! $this->validator) {
            $this->validateResolved();
        }
    }
}
