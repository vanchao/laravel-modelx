<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;
use mysql_xdevapi\Exception;
use Symfony\Component\Console\Exception\CommandNotFoundException;
use Symfony\Component\Console\Input\InputOption;
use Schema;

class Modelx extends GeneratorCommand
{
    const SPACE_SEPARATOR   = " ";
    const NEW_LINE          = "\r\n";

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:modelx';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model class with phpdoc';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:modelx {name} {--table= : table name you want entered}';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/model.stub';
    }

    /**
     * Build the model class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)->replaceTable($stub)->replacePhpDoc($stub, $name)->replaceClass($stub, $name);
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $stub = str_replace(
            ['{{namespace}}'],
            [$this->getNamespace($name)],
            $stub
        );

        return $this;
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);

        return str_replace('{{class}}', $class, $stub);
    }

    /**
     * Replace the table for the given stub.
     *
     * @param  string  $stub
     * @return $this
     */
    protected function replaceTable(&$stub)
    {
        $table = "";
        if(empty($this->option('table'))) $table = "";
        else $table = "protected \$table= '" . $this->option('table') . "';" . self::NEW_LINE;
        $stub = str_replace(
        '{{table}}', $table, $stub
        );

        return $this;
    }

    protected function replacePhpDoc(&$stub, $name)
    {
        $phpDoc = $this->getPhpDoc($name);
        $stub = str_replace(
            '{{modelPhpDoc}}', $phpDoc, $stub
        );

        return $this;
    }

    protected function getPhpDoc($name)
    {
        $tableName = $this->option('table');
        $nameSpace = $className = str_replace($this->getNamespace($name).'\\', '', $name);
        $fields_arr = Schema::getColumnListing($tableName);
        $start = '/**' . self::NEW_LINE;
        $start .= ' * class ' . $className . self::NEW_LINE;
        $start .= ' * @package ' . $nameSpace . self::NEW_LINE;
        $phpDoc_pre = ' * @property ';
        $end = ' */';
        $phpDoc = "";
        $phpDoc .= $start;
        foreach ($fields_arr as $val) {
            $phpDoc .= $phpDoc_pre . self::SPACE_SEPARATOR;
            $phpDoc .= Schema::getColumnType($tableName, $val);
            $phpDoc .= self::SPACE_SEPARATOR . $val . self::NEW_LINE;
        }
        $phpDoc .= $end;
        return $phpDoc;
    }

    public function handle()
    {
        if(empty($this->option('table'))) {
            $modelName = $this->argument('name');
            $this->line("php artisan make:modelx $modelName --table=table_name");
            $this->error("table_name must be setting");
            return false;
        }

        if(empty(Schema::hasTable($this->option('table')))) {
            $this->error('Table name your entered not exists or your database prefix was setting in your database.php config');
            return false;
        }

        $name = $this->qualifyClass($this->getNameInput());

        $path = $this->getPath($name);

        // First we will check to see if the class already exists. If it does, we don't want
        // to create the class and overwrite the user's code. So, we will bail out so the
        // code is untouched. Otherwise, we will continue generating this class' files.
        if ((! $this->hasOption('force') || ! $this->option('force')) && $this->alreadyExists($this->getNameInput())) {
            $this->error($this->type.' already exists!');

            return false;
        }

        // Next, we will generate the path to the location where this class' file should get
        // written. Then, we will build the class and make the proper replacements on the
        // stub files so that it gets the correctly formatted namespace and class name.
        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($name));

        $this->info($this->type.' created successfully.');
    }

}
