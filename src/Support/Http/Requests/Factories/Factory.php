<?php

declare(strict_types=1);

namespace Support\Http\Requests\Factories;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;
use Support\Http\Requests\Factories\Proxies\Model;

/**
 * @template TRequest of Request
 *
 * @method $this state(callable|array<string, mixed> $attributes)
 * @method $this count(int $count)
 * @method $this sequence(...$sequence)
 * @method $this prependState(callable|array<string, mixed> $attributes)
 * @method $this set(string $key, mixed $value)
 * @method $this recycle(\Illuminate\Database\Eloquent\Model $model)
 * @method $this forEachSequence(...$sequence)
 * @method $this crossJoinSequence(...$sequence)
 */
abstract class Factory
{
    use Concerns\ForwardsCalls;
    use Macroable {
        __call as macroCall;
    }

    /** @var class-string<TRequest> */
    protected string $request;

    private Proxies\Factory $proxy {
        get => $this->proxy ??= $this->makeProxy();
    }

    final public function __construct() {}

    /**
     * @param  (callable(array<string, mixed>): array<string, mixed>)|array<string, mixed>  $attributes
     * @return Collection<array-key, TRequest>|TRequest
     */
    public function make(callable|array $attributes = []): Request|Collection
    {
        $proxies = $this->proxy->make($attributes);

        if ($proxies instanceof Collection) {
            return $this->makeMultiple($proxies);
        }

        return $this->makeInstance($proxies->toArray());
    }

    /**
     * @param  Collection<array-key, Model>  $proxies
     * @return Collection<array-key, TRequest>
     */
    private function makeMultiple(Collection $proxies): Collection
    {
        return $proxies->map(fn (Model $proxy): Request => $this->makeInstance($proxy->toArray()));
    }

    /**
     * @param  (callable(array<string, mixed>): array<string, mixed>)|array<string, mixed>  $attributes
     * @return TRequest
     */
    private function makeInstance(callable|array $attributes = []): Request
    {
        $class = $this->request;

        $instance = new $class()->merge($attributes);

        if ($instance instanceof FormRequest) {
            $instance->setContainer(app())->setRedirector(app(Redirector::class));
        }

        return $instance;
    }

    /**
     * @param  (callable(array<string, mixed>, Model|null): array<string, mixed>)|array<string, mixed>  $attributes
     */
    public static function new(callable|array $attributes = []): static
    {
        return resolve(static::class)->state($attributes);
    }

    public static function times(null|int $count): static
    {
        return static::new()->count($count);
    }

    private function makeProxy(): Proxies\Factory
    {
        tap(
            $this,
            fn (self $factory) => Proxies\Factory::macro(
                '__definitionProvidedByRequestFactory',
                fn () => $factory->definition()
            )
        );

        return Proxies\Model::factory();
    }

    /**
     * @param  array<array-key, mixed>  $parameters
     */
    public function __call(string $method, array $parameters): static
    {
        static::hasMacro($method)
            ? $this->macroCall($method, $parameters)
            : $this->forwardDecoratedCallTo($this->proxy, $method, $parameters);

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    abstract public function definition(): array;
}
