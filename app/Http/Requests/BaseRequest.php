<?php

namespace App\Http\Requests;

use Illuminate\Container\Container;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Validation\ValidatesWhenResolvedTrait;

abstract class BaseRequest extends Request implements ValidatesWhenResolved
{
    use ValidatesWhenResolvedTrait;

    /**
     * @return array
     */
    abstract function rules();

    /**
     * Instância do Container
     *
     * @var \Illuminate\Container\Container
     */
    protected $container;



    /**
     * Obter a instância do validador para a request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidatorInstance()
    {
        $factory = $this->container->make(ValidationFactory::class);
        if (method_exists($this, 'validator')) {
            return $this->container->call([$this, 'validator'], compact('factory'));
        }
        return $factory->make(
            $this->validationData(), $this->container->call([$this, 'rules']), $this->messages(), $this->attributes()
        );
    }

    /**
     * Obter dados a serem validados a partir da request.
     *
     * @return array
     */
    protected function validationData()
    {
        return $this->all();
    }

    /**
     * Manipular uma tentativa de validação com falha..
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->response(
            $this->formatErrors($validator)
        ));

    }

    /**
     * Criar a resposta de falha de validação para a request
     *
     * @param  array  $errors
     * @return \Illuminate\Http\Response
     */
    public function response(array $errors)
    {
        return response()->json([
            'code' => 422,
            'status' => 'error',
            'message' => __('errors.validation'),
            'data' => $errors
        ], 422);
    }

    /**
     * Definir a instância do container
     *
     * @param  \Illuminate\Container\Container  $container
     * @return $this
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
        return $this;
    }

    /**
     * Retorna mensagens customizadas para os erros de validação
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }

    /**
     * Retorna attributos customizados para os erros de validação
     *
     * @return array
     */
    public function attributes()
    {
        return [];
    }

    /**
     * Formata os erros a partir da instância do Validator.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return array
     */
    protected function formatErrors(Validator $validator)
    {
//        $failed = $validator->failed();
//        $resultErrors = [];
//        foreach ($validator->getMessageBag()->toArray() as $field => $errors) {
//            foreach ($errors as $key => $error) {
//                $key = 'validation.'. $field .'.'. mb_strtolower(key($failed[$field]));
//                $resultErrors[$key] = $error;
//            }
//        }
//        return $resultErrors;

        return $validator->getMessageBag()->toArray();
    }
}
