<?php

namespace CodeProject\Providers;

use CodeProject\Entities\ProjectTasks;
use CodeProject\Events\TaskWasInclude;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //verifica quando cria a task, ele faz um push
        ProjectTasks::created(function ($task){
           Event::fire(new TaskWasInclude($task));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
       /*NÃO FUNCIONOU
        *  //para traduzir os dados faker em portugues
        $this->app->singleton(FakerGenerator::class, function () {
            return FakerFactory::create('pt_BR');
        });
       */
    }
}
