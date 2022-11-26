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
        $this->registerComponent('card');

        $this->registerComponent('form.field');
        $this->registerComponent('form.array');
        $this->registerComponent('form.input');
        $this->registerComponent('form.group');
        $this->registerComponent('form.mce');
        $this->registerComponent('form.textarea');
        $this->registerComponent('form.select');
        $this->registerComponent('form.picture');
        $this->registerComponent('form.checkbox');
        $this->registerComponent('form.radio');
        $this->registerComponent('form.icon');
        $this->registerComponent('form.sort');
        $this->registerComponent('form.json');
        $this->registerComponent('form.tag');
        $this->registerComponent('form.toggle');
        $this->registerComponent('form.done');
        $this->registerComponent('table.label');
        $this->registerComponent('table.item');
        $this->registerComponent('table.sort');

        $this->registerComponent('btn.delete');
        $this->registerComponent('btn.dropdown');
        $this->registerComponent('btn.toggle');
        $this->registerComponent('btn.modal');
        $this->registerComponent('item.tags');
        $this->registerComponent('item.tree-nav');

        $this->registerComponent('page.header');
        $this->registerComponent('page.listing');

        $this->registerComponent('filter.label');
        $this->registerComponent('filter.input');

        $this->registerComponent('modal');
    }

    protected function registerComponent(string $component)
    {
        Blade::component('lf-form::components.' . $component, 'lf.' . $component);
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
    }

}
