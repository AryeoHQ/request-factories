# Request Factories

This package extends Laravel's request handling by bringing the power of Eloquent factories directly to `\Illuminate\Http\Request`. With it, you can create test requests with predefined data structures, states, and methods — just like you would with Eloquent model factories.

This means you can:
- Use familiar factory patterns to generate HTTP request objects for testing
- Define reusable request templates with sensible defaults
- Create different request states (admin, guest, etc.) to test various scenarios
- Keep test data generation centralized and consistent across your test suite
- Leverage the full power of Laravel's factory features including sequences, states, and relationships

Making request creation behave more like Eloquent factories helps you write cleaner, more maintainable tests while reducing boilerplate code for request setup.

## Installation

You can install the package via Composer:

```bash
composer require aryeo/request-factories --dev
```

That's it — no configuration required.

## Usage

Creating request factories is straightforward. First, add the trait to your Request class and define a factory:

### 1. Add the trait to your Request

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Support\Http\Requests\Factories\Attributes\UseFactory;
use Support\Http\Requests\Factories\Provides\HasFactory;

#[UseFactory(UpdateUserRequestFactory::class)]
class UpdateUserRequest extends FormRequest
{
    use HasFactory;
}
```

### 2. Create your factory

```php
<?php

namespace Tests\Factories;

use App\Http\Requests\UpdateUserRequest;
use Support\Http\Requests\Factories\Factory;

class UpdateUserRequestFactory extends Factory
{
    protected string $request = UpdateUserRequest::class;

    public function definition(): array
    {
        return [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'is_admin' => false,
            'preferences' => ['theme' => 'dark'],
        ];
    }

    public function admin(): static
    {
        return $this->state([
            'is_admin' => true,
            'role' => 'administrator'
        ]);
    }

    public function withoutEmail(): static
    {
        return $this->state(['email' => null]);
    }
}
```

### 3. Usage

Now you can create request payloads easily for your HTTP tests:

```php
<?php

namespace Tests\Feature;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function test_it_updates_user()
    {
        $user = User::factory()->create();
        $payload = UpdateUserRequest::factory()->make()->toArray();

        $response = $this->post(route('users.update', $user), $payload);

        $response->assertOk();
    }

    public function test_validation_fails_without_email()
    {
        $user = User::factory()->create();
        $payload = UpdateUserRequest::factory()->withoutEmail()->make()->toArray();

        $response = $this->post(route('users.update', $user), $payload);

        $response->assertUnprocessable()->assertJsonValidationErrors(['email']);
    }
}
```
