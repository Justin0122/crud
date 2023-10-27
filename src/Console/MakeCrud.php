<?php

namespace Justin0122\Crud\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MakeCrud extends Command
{
    protected $signature = 'crud:make {name}';
    protected $description = 'Create a new CRUD';

    protected $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
    }

    public function handle()
    {
        $name = $this->argument('name');
        $formattedName = Str::studly($name);

        if ($this->generateLivewireFile($formattedName, $name)) {
            $this->createModelAndMigration($formattedName);
            $this->info("{$formattedName} CRUD files created successfully.");
        } else {
            $this->error("{$formattedName} CRUD files already exist.");
        }
    }

    private function generateLivewireFile($className, $viewName)
    {
        $livewirePath = app_path("Livewire/{$className}.php");

        if ($this->filesystem->exists($livewirePath)) {
            return false; // Already exists
        }

        $templatePath = __DIR__ . '/../Templates/livewire/livewires/template.php';
        $livewireTemplate = file_get_contents($templatePath);

        $directory = resource_path("views/livewire/{$className}");
        $this->filesystem->ensureDirectoryExists($directory);

        $livewireTemplate = str_replace('{{class_name}}', $className, $livewireTemplate);
        $livewireTemplate = str_replace('{{view_name}}', 'livewires.' . $viewName, $livewireTemplate);

        $this->filesystem->put($livewirePath, $livewireTemplate);
        $this->createViews($className);

        return true;
    }

    private function createViews($className)
    {

        $directory = resource_path("views/livewire/{$className}");
        $this->filesystem->ensureDirectoryExists($directory);

        $indexTemplatePath = __DIR__ . "/../Templates/livewire/views/index.blade.php";
        $indexTemplateContent = file_get_contents($indexTemplatePath);
        $indexTemplateContent = str_replace('{{class_name}}', $className, $indexTemplateContent);

        $this->filesystem->put("{$directory}/index.blade.php", $indexTemplateContent);

        $directory = resource_path("views/livewire/crud");
        $this->filesystem->ensureDirectoryExists($directory);

        $templates = ['create', 'edit'];
        foreach ($templates as $template) {
            $templatePath = __DIR__ . "/../Templates/livewire/views/{$template}.blade.php";
            $templateContent = file_get_contents($templatePath);
            $templateContent = str_replace('{{class_name}}', $className, $templateContent);

            $this->filesystem->put("{$directory}/{$template}.blade.php", $templateContent);
        }
    }

    private function createModelAndMigration($formattedName)
    {
        $this->call('make:model', ['name' => $formattedName]);
        $this->call('make:migration', ['name' => 'create_' . Str::snake($formattedName) . 's_table']);
    }
}
