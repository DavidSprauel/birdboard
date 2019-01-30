<?php

namespace Birdboard\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class CreateWriteClass extends GeneratorCommand
{
    protected $signature = 'make:write {name}';
    protected $description = 'Generate a Write Class';
    protected $type = 'Write Data Access';


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
        return $rootNamespace . '\Models\DataAccess\Write';
    }

    protected function getStub()
    {
        return app_path() . '/Console/Commands/Stubs/write.stub';
    }

    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return base_path() . '/app/' . str_replace('\\', '/', $name) . '.php';
    }
}
