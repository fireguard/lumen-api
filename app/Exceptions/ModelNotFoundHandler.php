<?php
namespace App\Exceptions;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class ModelNotFoundHandler
 */
class ModelNotFoundHandler
{
    public function render(ModelNotFoundException $exception)
    {
        return response([
            'code'      => 500,
            'status'    => 'error',
            'message'   => __('errors.internal_error'),
            'data'      => [
                'id'        => 'ModelNotFound',
                'title'     => __('errors.model_not_found'),
            ]
        ], 500);
    }
}
