<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use App\Console\CrudGenerator\Commands\GeneratorCommand;
// use App\Models\Permission;

// use Illuminate\Console\Command;

class CrudCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:make
                            {name : Nome da tabela}
                            {--route= : Nome da rota personalizada}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Criar operações vuetify Laravel CRUD';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Executando o gerador de crud ...');

        $this->table = $this->getNameInput();

        $this->runCommands([
            'php artisan optimize:clear',
            'php artisan migrate',
        ]);

        // If table not exist in DB return
        if (!$this->tableExists()) {
            $this->error("A tabela {$this->table} não existe");

            return false;
        }

        // Build the class name from table name
        $this->name = $this->_buildClassName();

        // Generate the crud
        $this
            ->buildOptions()
            ->buildController()
            ->buildModel()
            // ->buildSearchableTraits()
            ->buildService()
            ->buildRequest()
            ->buildFatory()
            ->buildSeeder()
            ->buildRoute()
            ->buildTraits()
            ->buildViews()
            ->buildPermissionSeeder();

        // $this->execute('composer dump-autoload');
        $this->runCommands([
            // 'npm run format',
            // 'php artisan db:seed'
        ]);

        $this->info('');
        $this->info("O CRUD da tabela {$this->name} foi criado com sucesso.");
        $this->info('');

        return true;
    }

    /**
     * Build the Controller Class and save in app/Http/Controllers.
     *
     * @return $this
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     *
     */
    protected function buildController()
    {
        $controllerPath = $this->_getControllerPath($this->name);

        if ($this->files->exists($controllerPath) && $this->ask('Já existe Controlador. Você quer substituir (y/n)?', 'y') == 'n') {
            return $this;
        }

        $this->info('Criando controlador...');

        $replace = $this->buildReplacements();

        $controllerTemplate = str_replace(
            array_keys($replace),
            array_values($replace),
            $this->getStub('Controller')
        );

        $this->write($controllerPath, $controllerTemplate);

        return $this;
    }

    /**
     * @return $this
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     *
     */
    protected function buildModel()
    {
        $modelPath = $this->_getModelPath($this->name);

        if ($this->files->exists($modelPath) && $this->ask('Já existe Modelo. Você quer substituir (y/n)?', 'y') == 'n') {
            return $this;
        }

        $this->info('Criando modelo...');

        // Make the models attributes and replacement
        $replace = array_merge($this->buildReplacements(), $this->modelReplacements());

        $modelTemplate = str_replace(
            array_keys($replace),
            array_values($replace),
            $this->getStub('Model')
        );

        $this->write($modelPath, $modelTemplate);

        return $this;
    }

    /**
     * @return $this
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     *
     */
    protected function buildRequest()
    {
        $requestPath = $this->_getRequestPath($this->name);

        if ($this->files->exists($requestPath) && $this->ask('Já existe Request. Você quer substituir (y/n)?', 'y') == 'n') {
            return $this;
        }

        $this->info('Criando Request...');

        $replace = array_merge($this->buildReplacements(), $this->modelReplacements());

        $requestTemplate = str_replace(
            array_keys($replace),
            array_values($replace),
            $this->getStub('Request')
        );

        $this->write($requestPath, $requestTemplate);

        return $this;
    }

    /**
     * @return $this
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     *
     * @throws \Exception
     */
    protected function buildTraits()
    {
        $traitPath = $this->_getTraitPath($this->name);

        if (!$this->files->exists($traitPath)) {

            $this->info('Criando base Trait Interface...');
            // $this->info("php artisan make:trait Traits/{$this->name}Trait");


            $this->runCommands([
                "php artisan make:trait {$this->name}Trait",
            ]);
        }


        return $this;
    }

    /**
     * @return $this
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     *
     * @throws \Exception
     */
    protected function buildSearchableTraits()
    {
        $serviceInterfacePath = $this->_getTraitPath('Searchable');
        if (!$this->files->exists($serviceInterfacePath)) {

            $this->info('Criando base Trait Interface...');

            $this->write($serviceInterfacePath, $this->getStub('Searchable'));
        }

        return $this;
    }

    /**
     * @return $this
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     *
     */
    protected function buildService()
    {

        // Make Service Class
        $servicePath = $this->_getServicePath('Base');
        if (!$this->files->exists($servicePath)) {

            $this->info('Criando base Service...');

            $this->write($servicePath, $this->getStub('BaseService'));
        }

        $servicePath = $this->_getServicePath($this->name);

        if ($this->files->exists($servicePath) && $this->ask('Já existe Service. Você quer substituir (y/n)?', 'y') == 'n') {
            return $this;
        }

        $this->info('Criando Service...');

        $replace = $this->buildReplacements();

        $serviceTemplate = str_replace(
            array_keys($replace),
            array_values($replace),
            $this->getStub('Service')
        );

        $this->write($servicePath, $serviceTemplate);

        return $this;
    }

    /**
     * @return $this
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     *
     */
    protected function buildFatory()
    {
        // $factoryPath = $this->_getFactoryPath($this->name);

        // if ($this->files->exists($factoryPath) && $this->ask('Já existe Factory. Você quer substituir (y/n)?', 'y') == 'n') {
        //   return $this;
        // }

        $this->info('Criando Factory...');

        $this->runCommands([
            "php artisan make:factory {$this->_buildClassName()}Factory --model={$this->_buildClassName()}",
        ]);

        return $this;
    }

    protected function buildSeeder()
    {
        $seederPath = base_path("database/seeders/{$this->_buildClassName()}Seeder.php");

        if ($this->files->exists($seederPath) && $this->ask('Já existe Seeder. Você quer substituir (y/n)?', 'y') == 'n') {
            return $this;
        }

        $this->info('Criando Seeder...');

        $this->runCommands([
            "php artisan make:seeder {$this->_buildClassName()}Seeder",
        ]);

        return $this;
    }

    protected function buildPermissionSeeder()
    {
        $this->info('Criando Recurso...');

        $permissionPath = base_path('database/seeders/PermissionSeeder.php');
        if (!$this->files->exists($permissionPath)) {
            $this->error('Arquivo Permission não encontrado...');
            return $this;
        }

        $permissionContent = $this->files->get($permissionPath);
        $resource = Str::camel(Str::singular($this->name));
        $permissionContent = str_replace(
            "]; // addResources",
            "\t[\n\t\t\t\t'name' => '{$resource}',\n\t\t\t\t'description' => 'Gerenciar {$resource}s',\n\t\t\t],\n\t\t]; // addResources",
            $permissionContent
        );

        // var_dump($permissionContent);
        $this->files->put($permissionPath, $permissionContent);


        return $this;

        // return str_replace(
        //   "\t\t]; // addPermissions",
        //   "{$this->getStub($permission)}\n\t\t]; // addPermissions",
        //   $permission
        // );
    }

    /**
     * @return $this
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     *
     */
    protected function buildRoute()
    {
        $this->info('Criando as Rotas...');

        $routePath = base_path('routes/web.php');
        if (!$this->files->exists($routePath)) {
            $this->error('Arquivo de rotas não encontrado...');
            return $this;
        }

        $routeContent = $this->files->get($routePath);
        $routeContent = $this->prependControllerImport($routeContent);
        $routeContent = $this->appendNewRoute($routeContent);

        $this->files->put($routePath, $routeContent);

        return $this;
    }

    protected function prependControllerImport($routeContent)
    {
        return str_replace(
            '// routeImport',
            "use App\Http\Controllers\\{$this->name}Controller;\n// routeImport",
            $routeContent
        );
    }

    protected function appendNewRoute($routeContent)
    {
        $replace = $this->buildReplacements();
        $routeTemplate = str_replace(
            array_keys($replace),
            array_values($replace),
            $this->getStub('Route')
        );
        return str_replace(
            '// addRoute',
            $routeTemplate,
            $routeContent
        );
    }


    /**
     * @return $this
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     *
     * @throws \Exception
     */
    protected function buildViews()
    {
        $this->info('Criando as Páginas Vue...');

        $tableHead = "";
        $useFormCreate = "";
        $useForm = "";
        $useFormEdit = "";
        $tableHeaders = "";
        $tableBody = "\n";
        // $viewRows = "\n";
        $form = "\n";

        foreach ($this->getFilteredColumns() as $column) {
            $title = Str::title(str_replace('_', ' ', $column));

            $useFormCreate .= $this->getFormFieldsCriate($column);
            $useFormEdit .= $this->getFormFieldsEdit($column);
            $useForm .= $this->getFormFields($column);
            $tableHeaders .= $this->getHead($title);
            // $tableHead .= $this->getHead($title);
            $tableBody .= $this->getBody($column);
            // $viewRows .= $this->getField($title, $column, 'view-field');
            $form .= $this->getField($title, $column, 'form-field');
        }

        $replace = array_merge($this->buildReplacements(), [
            '{{tableHeaders}}' => $tableHeaders,
            '{{tableHeader}}' => $tableHead,
            '{{tableBody}}' => $tableBody,
            // '{{routeName}}' => $this->_buildClassName(),
            // '{{viewRows}}' => $viewRows,
            '{{useFormCreate}}' => $useFormCreate,
            '{{useFormEdit}}' => $useFormEdit,
            '{{useForm}}' => $useForm,
            '{{form}}' => $form,
        ]);

        // $this->buildLayout();

        // foreach (['Index', 'Create', 'Edit', 'Form', 'Show'] as $view) {
        foreach (['Index', 'Create', 'Edit', 'Form', 'Show'] as $view) {
            $viewTemplate = str_replace(
                array_keys($replace),
                array_values($replace),
                $this->getStub("views/{$view}")
            );

            $this->write($this->_getViewPath($view), $viewTemplate);
        }

        return $this;
    }

    /**
     * Make the class name from table name.
     *
     * @return string
     */
    private function _buildClassName()
    {
        return Str::studly(Str::singular($this->table));
    }
}
