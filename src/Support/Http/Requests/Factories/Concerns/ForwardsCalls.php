<?php

declare(strict_types=1);

namespace Support\Http\Requests\Factories\Concerns;

use BadMethodCallException;

trait ForwardsCalls
{
    use \Illuminate\Support\Traits\ForwardsCalls {
        forwardDecoratedCallTo as illuminateForwardDecoratedCallTo;
    }

    /** @var array<array-key, string> */
    private array $forwardableMethods = [
        'count',
        'times',
        'state',
        'prependState',
        'set',
        'sequence',
        'forEachSequence',
        'crossJoinSequence',
        'recycle',
    ];

    private function isForwardableCall(string $method): bool
    {
        return $this->proxy::hasMacro($method) || (
            in_array($method, $this->forwardableMethods, true) && method_exists($this->proxy, $method)
        );
    }

    /**
     * @param  array<array-key, mixed>  $parameters
     */
    private function forwardDecoratedCallTo(object $object, string $method, array $parameters): mixed
    {
        throw_unless(
            $this->isForwardableCall($method),
            BadMethodCallException::class,
            sprintf('Method %s::%s does not exist.', static::class, $method)
        );

        $result = $this->forwardCallTo($object, $method, $parameters);

        if (is_a($result, $this->proxy::class)) {
            $this->proxy = $result;

            return $this;
        }

        return $result;
    }
}
