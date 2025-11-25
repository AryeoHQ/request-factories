<?php

declare(strict_types=1);

namespace Tests\Support\Requests\FormRequests;

use Illuminate\Support\ValidatedInput;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\Attributes\Test;
use Tests\Fixtures;

class FormRequestTest extends \Tests\TestCase
{
    #[Test]
    public function it_interacts_with_factory(): void
    {
        $this->assertInstanceOf(
            Fixtures\Requests\FormRequests\Factory::class,
            Fixtures\Requests\FormRequests\FormRequest::factory(),
        );
    }

    #[Test]
    public function it_skips_validation_when_making(): void
    {
        $request = Fixtures\Requests\FormRequests\FormRequest::factory()->make();

        $this->assertInstanceOf(Fixtures\Requests\FormRequests\FormRequest::class, $request);
    }

    #[Test]
    public function it_validates_when_looking_for_validated_data(): void
    {
        $this->expectException(ValidationException::class);

        /** @var Fixtures\Requests\FormRequests\FormRequest */
        $request = Fixtures\Requests\FormRequests\FormRequest::factory()->make();

        $request->validated('middle_name');
    }

    #[Test]
    public function it_can_retrieve_validated_data(): void
    {
        $request = Fixtures\Requests\FormRequests\FormRequest::factory()->middleName()->make();

        $this->assertSame(
            $request->middle_name,
            $request->validated('middle_name'),
        );
    }

    #[Test]
    public function it_retrieves_data_to_be_validated(): void
    {
        $request = Fixtures\Requests\FormRequests\FormRequest::factory()->middleName()->make();

        $this->assertSame($request->toArray(), $request->validationData());
    }

    #[Test]
    public function it_validates_when_getting_safe(): void
    {
        $this->expectException(ValidationException::class);

        $request = Fixtures\Requests\FormRequests\FormRequest::factory()->make();

        $request->safe();
    }

    #[Test]
    public function it_can_retrieve_safe_data(): void
    {
        $request = Fixtures\Requests\FormRequests\FormRequest::factory()->middleName()->make();

        $this->assertInstanceOf(ValidatedInput::class, $request->safe());
        $this->assertSame($request->middle_name, data_get($request->safe(), 'middle_name'));
    }
}
