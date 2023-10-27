<?php

namespace Justin\Crud\Console;

use Illuminate\Console\Command;

class DeleteCrud extends Command
{
    protected $signature = 'crud:delete {name}';
    protected $description = 'Delete a CRUD';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $name = $this->argument('name');

        //logic to delete the crud files
    }
}
