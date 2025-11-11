<?php

declare(strict_types=1);

namespace Support\Http\Requests\Factories\Proxies;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Model>
 *
 * @method array<string, mixed> __definitionProvidedByRequestFactory()
 */
class Factory extends \Illuminate\Database\Eloquent\Factories\Factory
{
    /** @var class-string<Model> */
    protected $model = Model::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return $this->__definitionProvidedByRequestFactory();
    }
}
