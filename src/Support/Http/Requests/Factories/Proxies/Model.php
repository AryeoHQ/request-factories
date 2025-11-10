<?php

declare(strict_types=1);

namespace Support\Http\Requests\Factories\Proxies;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[UseFactory(Factory::class)]
class Model extends \Illuminate\Database\Eloquent\Model
{
    /** @use HasFactory<Factory>  */
    use HasFactory;

    public $timestamps = false;

    protected static $isBroadcasting = false;

    protected static $modelsShouldAutomaticallyEagerLoadRelationships = false;
}
