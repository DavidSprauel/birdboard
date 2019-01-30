<?php

namespace Birdboard\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class CreateNewModelCommand extends GeneratorCommand
{

    protected $name = 'make:api-model';
    protected $signature = 'make:api-model {name} {--rwb}';
    protected $description = 'Create Api Model';
    protected $type = 'Model';

    public function handle()
    {
        if (parent::handle() === false) {
            return;
        }

        if($this->option('rwb')) {
            $this->createReadWriteBusiness();
        }
    }

    protected function getOptions()
    {
        return [];
    }

    protected function getClassName()
    {
        return ucwords(camel_case($this->getNameInput()));
    }

    protected function buildClass($name = null)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceClass($stub, $this->getClassName());
    }

    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name) . '\\', '', $name);
        $stub = str_replace('{{class}}', $class, $stub);

        return $stub;
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Models\Entities\Eloquent';
    }

    protected function getStub()
    {
        return app_path() . '/Console/Commands/Stubs/models.stub';
    }

    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return base_path() . '/app/' . str_replace('\\', '/', $name) . '.php';
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the model.'],
        ];
    }

    protected function createReadWriteBusiness() {
        $className = ucwords(camel_case($this->getNameInput()));

        $this->call('make:write', [
            'name' => $className,
        ]);

        $this->call('make:read', [
            'name' => $className,
        ]);

        $this->call('make:business', [
            'name' => $className,
        ]);
    }
}
