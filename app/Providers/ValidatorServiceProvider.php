<?php

namespace App\Providers;

use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Support\ServiceProvider;
use App\Http\Requests\BaseRequest;
use Symfony\Component\HttpFoundation\Request;

class ValidatorServiceProvider extends  ServiceProvider
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
        // PasswordValidator
        $this->app['validator']->extend('password', 'App\Validators\PasswordValidator@validPassword');
        //$this->app['validator']->extend('old_password', 'App\Validators\PasswordValidator@validOldPassword');


        // DateTimeValidator
        //$this->app['validator']->extend('hours', 'App\Validators\DateTimeValidator@hours');
        //$this->app['validator']->extend('times', 'App\Validators\DateTimeValidator@times');

        // FilesValidator
        //$this->app['validator']->extend('valid_document', 'App\Validators\FilesValidator@validDocument');
        //$this->app['validator']->extend('valid_audio', 'App\Validators\FilesValidator@validAudio');
        $this->app['validator']->extend('valid_image', 'App\Validators\FilesValidator@validImage');
        //$this->app['validator']->extend('valid_link', 'App\Validators\FilesValidator@validLink');

        // PhoneValidator
        //$this->app['validator']->extend('valid_phone', 'App\Validators\PhoneValidator@validPhone');

        // AddressValidator
        //$this->app['validator']->extend('valid_zip', 'App\Validators\AddressValidator@validZipCode');

        // DocumentValidator
        //$this->app['validator']->extend('valid_company_document', 'App\Validators\DocumentValidator@validCompanyDocument');
        //$this->app['validator']->extend('valid_state_registration_document', 'App\Validators\DocumentValidator@validStateRegistrationDocument');
        //$this->app['validator']->extend('valid_municipal_registration_document', 'App\Validators\DocumentValidator@validMunicipalRegistrationDocument');
        //$this->app['validator']->extend('valid_employee_document', 'App\Validators\DocumentValidator@validEmployeeDocument');
        //$this->app['validator']->extend('valid_rg_document', 'App\Validators\DocumentValidator@validRgDocument');
        //$this->app['validator']->extend('valid_ctps_document', 'App\Validators\DocumentValidator@validCtpsDocument');
    }

}
