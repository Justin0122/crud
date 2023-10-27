<?php

namespace Justin0122\Crud;

use Illuminate\Support\ServiceProvider;
use Justin0122\Crud\Console\DeleteCrud;
use Justin0122\Crud\Console\MakeCrud;

class CrudServiceProvider extends ServiceProvider
{
    protected array $commands = [
        MakeCrud::class,
        DeleteCrud::class,
    ];


    /**
     * Register bindings in the container.
     */
    public function register(): void
    {
        $this->commands($this->commands);
    }

    /**
     * Bootstrap any package resources.
     */
    public function boot()
    {
    }
}
