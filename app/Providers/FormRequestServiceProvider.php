<?php

namespace App\Providers;

use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Support\ServiceProvider;
use App\Http\Requests\BaseRequest;
use Symfony\Component\HttpFoundation\Request;

class FormRequestServiceProvider extends  ServiceProvider
{
    /**
     * Registrar o provedor de serviços.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Inicializar os serviços de aplicação..
     *
     * @return void
     */
    public function boot()
    {
        $this->app->afterResolving(ValidatesWhenResolved::class, function ($resolved) {
            $resolved->validate();
        });
        $this->app->resolving(BaseRequest::class, function ($request, $app) {
            $this->initializeRequest($request, $app['request']);
            $request->setContainer($app);
        });
    }

    /**
     * Inicializar a instância do base request com os dados da request.
     *
     * @param  BaseRequest $baseRequest
     * @param  \Symfony\Component\HttpFoundation\Request  $current
     * @return void
     */
    protected function initializeRequest(BaseRequest $baseRequest, Request $current)
    {
        $files = $current->files->all();
        $files = is_array($files) ? array_filter($files) : $files;
        $baseRequest->initialize(
            $current->query->all(), $current->request->all(), $current->attributes->all(),
            $current->cookies->all(), $files, $current->server->all(), $current->getContent()
        );
        $baseRequest->setJson($current->json());
    }
}
