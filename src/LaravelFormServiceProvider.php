<?php

namespace Hungnm28\LaravelForm;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class LaravelFormServiceProvider extends ServiceProvider
{
    protected $commands = [
        Commands\ModelCommand::class
        ,Commands\InitAuth::class
        ,Commands\InitCast::class
        ,Commands\InitMix::class
        ,Commands\InitLayout::class
        ,Commands\InitProvider::class
        ,Commands\InitIcon::class
        ,Commands\InitRoute::class
        ,Commands\InitGitignore::class
        ,Commands\InitModule::class
        ,Commands\MakeIndex::class
        ,Commands\MakeCreate::class
        ,Commands\MakeEdit::class
        ,Commands\MakeShow::class
        ,Commands\MakeListing::class
        ,Commands\MakePage::class
        ,Commands\MakeAdmin::class
        ,Commands\MakeRoute::class
        ,Commands\CreateUser::class
        ,Commands\NewAdmin::class
        ,Commands\NewModule::class
        ,Commands\UpdateComposerModule::class
        ,Commands\SetupDatabase::class
        ,Commands\UseWebpack::class
    ];
    protected $components = [
        'btn.delete', 'btn.dropdown', 'btn.modal', 'btn.toggle'
        , 'filter.input', 'filter.label'
        , 'form.array', 'form.checkbox', 'form.done', 'form.field'
        , 'form.group', 'form.icon', 'form.input', 'form.json'
        , 'form.mce', 'form.picture', 'form.radio', 'form.row'
        , 'form.select', 'form.sort', 'form.tag', 'form.textarea', 'form.toggle', 'form.loading'
        , 'item.jsons', 'item.tags', 'item.tree-nav'
        , 'modal'
        , 'page.header', 'page.listing'
        , 'table.item', 'table.label'
        , 'table.sort'
        ,'box.errors'
        ,'card'
    ];

    public function register()
    {
        parent::register();
        $this->app->bind('laravelform', function($app) {
            return new LaravelForm();
        });
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'lf-form');
        $this->configureCommands();
        $this->configureComponents();
        $this->registerPublishing();
    }

    protected function configureComponents()
    {
        $this->registerComponent();
    }

    protected function registerComponent()
    {
        foreach ($this->components as $component){
            $path = resource_path("views/components/lf/") . str_replace(".","/",$component) . ".blade.php";
            if(!file_exists($path)){
                Blade::component('lf-form::components.' . $component, 'lf.' . $component);
            }
        }
    }

    protected function configureCommands()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands($this->commands);
    }
    protected function registerPublishing()
    {
        $this->publishes([
            __DIR__.'/Commands/stubs/' => base_path('stubs/laravel-form-stubs'),
        ], ['laravel-form-stub']);
        $this->publishes([
            __DIR__ . '/../publishes/database' => database_path()
        ], 'laravel-form-database');
        $this->publishes([
            __DIR__ . '/../publishes/helpers' => base_path('helpers')
        ], 'laravel-form-helper');
        $this->publishes([
            __DIR__ . '/../publishes/webpack.mix.js' => base_path('webpack.mix.js')
        ], 'laravel-use-webpack');
        $this->publishes([
            __DIR__ . '/../resources/views/components' =>base_path("resources/views/components/lf")
        ], 'laravel-form');

    }

}
