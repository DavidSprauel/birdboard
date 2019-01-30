<?php

namespace Birdboard\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class CreateBusiness extends GeneratorCommand
{
    protected $signature = 'make:business {name}';
    protected $description = 'Generate a Business Class';
    protected $type = 'Business';


    protected function buildClass($name = null)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceClass($stub, $this->getClassName());
    }

    protected function getClassName()
    {
        return ucwords(camel_case($this->getNameInput()));
    }

    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name) . '\\', '', $name);
        $stub = str_replace('{{class}}', $class, $stub);

        return $stub;
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Models\Business';
    }

    protected function getStub()
    {
        return app_path() . '/Console/Commands/Stubs/business.stub';
    }

    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return base_path() . '/app/' . str_replace('\\', '/', $name) . '.php';
    }
}
