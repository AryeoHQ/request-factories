<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench;

abstract class TestCase extends Testbench\TestCase
{
    protected function defineDatabaseMigrations()
    {
        Schema::create('websites', function (Blueprint $table): void {
            $table->id();
            $table->string('domain');
            $table->string('tld');
            $table->timestamps();
        });
    }
}
