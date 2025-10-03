<?php

namespace App\Console\CrudGenerator\Commands;

use App\Console\CrudGenerator\VilvCrudGenerator;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Process\Process;

/**
 * Class GeneratorCommand.
 */
abstract class GeneratorCommand extends Command
{
    /**
     * The filesystem instance.
     */
    protected Filesystem $files;

    /**
     * Do not make these columns fillable in Model or views.
     *
     * @var array
     */
    protected $unwantedColumns = [
        'id',
        'uuid',
        'ulid',
        'password',
        'email_verified_at',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Table name from argument.
     *
     * @var string
     */
    protected $table = null;

    /**
     * Formatted Class name from Table.
     *
     * @var string
     */
    protected $name = null;

    /**
     * Store the DB table columns.
     *
     * @var array
     */
    private $tableColumns = null;

    /**
     * Model Namespace.
     *
     * @var string
     */
    protected $modelNamespace = 'App\Models';

    /**
     * Controller Namespace.
     *
     * @var string
     */
    protected $controllerNamespace = 'App\Http\Controllers';

    /**
     * Request Namespace.
     *
     * @var string
     */
    protected $requestNamespace = 'App\Http\Requests';

    /**
     * Service Namespace.
     *
     * @var string
     */
    protected $serviceNamespace = 'App\Services';

    /**
     * Application Layout
     *
     * @var string
     */
    protected $layout = 'layouts.app';

    /**
     * Custom Options name
     *
     * @var array
     */
    protected $options = [];

    /**
     * Create a new controller creator command instance.
     *
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
        $this->unwantedColumns = config('crud.model.unwantedColumns', $this->unwantedColumns);
        $this->modelNamespace = config('crud.model.namespace', $this->modelNamespace);
        $this->controllerNamespace = config('crud.controller.namespace', $this->controllerNamespace);
        $this->layout = config('crud.layout', $this->layout);
    }

    /**
     * Generate the controller.
     *
     * @return $this
     */
    abstract protected function buildController();

    /**
     * Generate the Model.
     *
     * @return $this
     */
    abstract protected function buildModel();

    /**
     * Generate the views.
     *
     * @return $this
     */
    abstract protected function buildViews();

    /**
     * Build the directory if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }

        return $path;
    }

    /**
     * Write the file/Class.
     */
    protected function write($path, $content)
    {
        $directory = $this->files->dirname($path);

        if (! $this->files->isDirectory($directory)) {
            $this->files->makeDirectory($directory, 0755, true);
        }

        $this->files->put($path, $content);
    }

    /**
     * Get the stub file.
     *
     * @param  string  $type
     * @param  bool  $content
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function getStub($type, $content = true)
    {
        $stub_path = config('crud.stub_path', 'default');
        if ($stub_path == 'default') {
            $stub_path = __DIR__.'/../stubs/';
        }

        $path = Str::finish($stub_path, '/')."{$type}.stub";

        if (! $content) {
            return $path;
        }

        return $this->files->get($path);
    }

    /**
     * @return string
     */
    private function _getSpace($no = 1)
    {
        $tabs = '';
        for ($i = 0; $i < $no; $i++) {
            $tabs .= "\t";
        }

        return $tabs;
    }

    /**
     * @return string
     */
    protected function _getControllerPath($name)
    {
        return app_path($this->_getNamespacePath($this->controllerNamespace)."{$name}Controller.php");
    }

    /**
     * @return string
     */
    protected function _getRequestPath($name)
    {
        return app_path($this->_getNamespacePath($this->requestNamespace)."{$name}Request.php");
    }

    /**
     * @return string
     */
    protected function _getServicePath($name)
    {
        return app_path($this->_getNamespacePath('App\Services')."{$name}Service.php");
    }

    /**
     * @return string
     */
    protected function _getTraitPath($name)
    {
        return app_path("Traits/{$name}Trait.php");
    }

    /**
     * @return string
     */
    protected function _getModelPath($name)
    {
        return $this->makeDirectory(app_path($this->_getNamespacePath($this->modelNamespace)."{$name}.php"));
    }

    /**
     * Get the path from namespace.
     *
     *
     * @return string
     */
    private function _getNamespacePath($namespace)
    {
        $str = Str::start(Str::finish(Str::after($namespace, 'App'), '\\'), '\\');

        return str_replace('\\', '/', $str);
    }

    /**
     * Get the default layout path.
     *
     * @return string
     */
    private function _getLayoutPath()
    {
        return $this->makeDirectory(resource_path('/views/layouts/app.blade.php'));
    }

    /**
     * Get the default factory path.
     *
     * @return string
     */
    private function _getFactoryPath($name)
    {
        return $this->makeDirectory(database_path("/factories/{$name}Factory.php"));
    }

    /**
     * Get the default seeder path.
     *
     * @return string
     */
    private function _getSeederPath($name)
    {
        return $this->makeDirectory(database_path("/seeders/{$name}Seeder.php"));
    }

    /**
     * @return string
     */
    protected function _getViewPath($view)
    {
        $name = $this->_getPagePath();

        return $this->makeDirectory(resource_path("/js/Pages/{$name}/{$view}.vue"));
    }

    protected function _getPagePath()
    {
        $name = ucfirst($this->name);
        if (isset($this->options['route'])) {
            // Divida a string original nos pontos
            $parts = explode('.', $this->options['route']);
            // Capitalize cada parte da string
            $capitalizedParts = array_map('ucfirst', $parts);
            // Una as partes com a barra como separador
            $name = implode('/', $capitalizedParts);
        }

        return $name;
    }

    /**
     * Build the replacement.
     *
     * @return array
     */
    protected function buildReplacements()
    {
        return [
            '{{layout}}' => $this->layout,
            '{{modelName}}' => $this->name,
            '{{modelTitle}}' => Str::title(Str::snake($this->name, ' ')),
            '{{modelNamespace}}' => $this->modelNamespace,
            '{{controllerNamespace}}' => $this->controllerNamespace,
            '{{requestNamespace}}' => $this->requestNamespace,
            '{{serviceNamespace}}' => $this->serviceNamespace,
            '{{modelNamePluralLowerCase}}' => Str::camel(Str::plural($this->name)),
            '{{modelNamePluralUpperCase}}' => ucfirst(Str::plural($this->name)),
            '{{modelNameLowerCase}}' => Str::camel($this->name),
            '{{modelRoute}}' => $this->_getRoute(),
            '{{modelUrl}}' => $this->_getUrl(),
            '{{modelView}}' => Str::kebab($this->name),
            '{{tableName}}' => Str::camel(Str::plural($this->name)),
            '{{pathView}}' => $this->_getPagePath(),
        ];
    }

    protected function _getUrl()
    {
        if (isset($this->options['route'])) {
            return str_replace('.', '/', $this->options['route']);
        } else {
            return Str::kebab(Str::plural($this->name));
        }
    }

    protected function _getRoute()
    {
        return $this->options['route'] ?? Str::kebab(Str::plural($this->name));
    }

    /**
     * Build the form fields for form.
     *
     * @param  string  $type
     * @return mixed
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function getField($title, $column, $type = 'form-field')
    {
        $replace = array_merge($this->buildReplacements(), [
            '{{title}}' => $title,
            '{{column}}' => $column,
            '{{column_snake}}' => Str::snake($column),
        ]);

        return str_replace(
            array_keys($replace),
            array_values($replace),
            $this->getStub("views/{$type}")
        );
    }

    /**
     * @return mixed
     */
    protected function getFormFields($column)
    {
        $replace = array_merge($this->buildReplacements(), [
            '{{column}}' => $column,
        ]);

        return str_replace(
            array_keys($replace),
            array_values($replace),
            "\n".$this->_getSpace(2).'form.{{column}} = props.data.{{column}}'
        );
    }

    /**
     * @return mixed
     */
    protected function getFormFieldsCriate($column)
    {
        $replace = array_merge($this->buildReplacements(), [
            '{{column}}' => $column,
        ]);

        return str_replace(
            array_keys($replace),
            array_values($replace),
            "\n".$this->_getSpace(1)."{{column}}: '',"
        );
    }

    /**
     * @return mixed
     */
    protected function getFormFieldsEdit($column)
    {
        $replace = array_merge($this->buildReplacements(), [
            '{{column}}' => $column,
        ]);

        return str_replace(
            array_keys($replace),
            array_values($replace),
            "\n".$this->_getSpace(1).'{{column}}: props.data.{{column}},'
        );
    }

    /**
     * @return mixed
     */
    protected function getHead($title)
    {
        $key = Str::snake($title);
        // $title = Str::title(str_replace('_', ' ', $title));
        $replace = array_merge($this->buildReplacements(), [
            '{{title}}' => Str::title(str_replace('_', ' ', $title)),
            '{{key}}' => $key,
        ]);

        return str_replace(
            array_keys($replace),
            array_values($replace),
            "\n".$this->_getSpace(1)."{ title: '{{title}}', key: '{{key}}' },"
        );
    }

    /**
     * @return mixed
     */
    protected function getBody($column)
    {
        $replace = array_merge($this->buildReplacements(), [
            '{{column}}' => $column,
        ]);

        return str_replace(
            array_keys($replace),
            array_values($replace),
            $this->_getSpace(11).'<td>{{ ${{modelNameLowerCase}}->{{column}} }}</td>'."\n"
        );
    }

    /**
     * Make layout if not exists.
     *
     * @throws \Exception
     */
    protected function buildLayout(): void
    {
        if (! (view()->exists($this->layout))) {

            $this->info('Creating Layout ...');

            if ($this->layout == 'layouts.app') {
                $this->files->copy($this->getStub('layouts/app', false), $this->_getLayoutPath());
            } else {
                throw new \Exception("{$this->layout} layout not found!");
            }
        }
    }

    /**
     * Get the DB Table columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        if (empty($this->tableColumns)) {
            $this->tableColumns = Schema::getColumns($this->table);
        }

        return $this->tableColumns;
    }

    /**
     * @return array
     */
    protected function getFilteredColumns()
    {
        $unwanted = $this->unwantedColumns;
        $columns = [];

        foreach ($this->getColumns() as $column) {
            $columns[] = $column['name'];
        }

        return array_filter($columns, function ($value) use ($unwanted) {
            return ! in_array($value, $unwanted);
        });
    }

    /**
     * Make model attributes/replacements.
     *
     * @return array
     */
    protected function modelReplacements()
    {
        $properties = '*';
        $rulesArray = [];
        $softDeletesNamespace = $softDeletes = '';

        foreach ($this->getColumns() as $column) {
            $properties .= "\n * @property \${$column['name']}";

            if (! $column['nullable']) {
                $rulesArray[$column['name']] = ['required'];
            }

            if ($column['nullable'] || $column['type_name'] == 'default') {
                $rulesArray[$column['name']] = ['nullable'];
            }

            if ($column['type_name'] == 'integer') {
                $rulesArray[$column['name']][] = 'integer';
            }

            if ($column['type_name'] == 'bool') {
                $rulesArray[$column['name']][] = 'boolean';
            }

            if ($column['type_name'] == 'uuid') {
                $rulesArray[$column['name']][] = 'uuid';
            }

            if ($column['type_name'] == 'text' || $column['type_name'] == 'mediumText') {
                $rulesArray[$column['name']][] = 'string';
            }

            if ($column['type_name'] == 'varchar' || $column['type_name'] == 'longText') {
                $rulesArray[$column['name']][] = 'string';
            }

            if ($column['name'] == 'deleted_at') {
                $softDeletesNamespace = "use Illuminate\Database\Eloquent\SoftDeletes;\n";
                $softDeletes = ' SoftDeletes,';
            }
        }

        $rules = function () use ($rulesArray) {
            $rules = '';
            // Exclude the unwanted rulesArray
            $rulesArray = Arr::except($rulesArray, $this->unwantedColumns);
            // Make rulesArray
            foreach ($rulesArray as $col => $rule) {
                $rules .= "\n\t\t\t'{$col}' => ['".implode('\', \'', $rule)."'],";
            }

            return $rules;
        };

        $fillable = function () {

            /** @var array $filterColumns Exclude the unwanted columns */
            $filterColumns = $this->getFilteredColumns();

            // Add quotes to the unwanted columns for fillable
            array_walk($filterColumns, function (&$value) {
                $value = "\n\t\t'".$value."'";
            });

            // CSV format
            return implode(', ', $filterColumns);
        };

        $properties .= "\n *";

        [$relations, $properties] = (new VilvCrudGenerator($this->table, $properties, $this->modelNamespace))->getEloquentRelations();

        return [
            '{{fillable}}' => $fillable(),
            '{{searchable}}' => $fillable(),
            '{{rules}}' => $rules(),
            '{{relations}}' => $relations,
            '{{properties}}' => $properties,
            '{{softDeletesNamespace}}' => $softDeletesNamespace,
            '{{softDeletes}}' => $softDeletes,
        ];
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return trim($this->argument('name'));
    }

    /**
     * Build the options
     *
     * @return $this|array
     */
    protected function buildOptions()
    {
        $route = $this->option('route');

        if (! empty($route)) {
            $this->options['route'] = $route;
        }

        return $this;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'O nome da tabela.'],
        ];
    }

    /**
     * Is Table exist in DB.
     *
     * @return mixed
     */
    protected function tableExists()
    {
        return Schema::hasTable($this->table);
    }

    /**
     * Installs the given Composer Packages into the application.
     */
    protected function requireComposerPackages(array $packages, bool $asDev = false): bool
    {
        $command = array_merge(
            ['composer', 'require'],
            $packages,
            $asDev ? ['--dev'] : [],
        );

        return (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            }) === 0;
    }

    /**
     * Run the given commands.
     */
    protected function runCommands(array $commands): void
    {
        $process = Process::fromShellCommandline(implode(' && ', $commands), null, null, null, null);

        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            try {
                $process->setTty(true);
            } catch (RuntimeException $e) {
                $this->output->writeln('  <bg=yellow;fg=black> WARN </> '.$e->getMessage().PHP_EOL);
            }
        }

        $process->run(function ($type, $line) {
            $this->output->write('    '.$line);
        });
    }
}
