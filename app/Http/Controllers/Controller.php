<?php

namespace App\Http\Controllers;

use App\Models\AbstractModel;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Laravel\Lumen\Routing\Controller as BaseController;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class Controller extends BaseController
{

    public function responseSuccess($message, $code = 200, $data = null, TransformerAbstract $transformer = null)
    {
        return $this->createResponse('success', $message, $code, $data, $transformer);
    }

    public function responseError($message, $code = 500, $data = null, TransformerAbstract $transformer = null)
    {
        return $this->createResponse('error', $message, $code, $data, $transformer);
    }

    protected function createResponse($status, $message, $code = 500, $data = null, TransformerAbstract $transformer = null)
    {
        if ($data instanceof LengthAwarePaginator && !is_null($transformer)) {

            $data =  $this->getDataForCollectionPaginator($data, $transformer);

        } else if ( $data instanceof AbstractModel && !is_null($transformer) ) {

            $data =  $this->getDataForModel($data, $transformer);
        }


        return response()->json([
            'code' => $code,
            'status'  => $status,
            'message' => $message,
            'data'    => $data
        ], $code);
    }

    protected function getDataForCollectionPaginator(LengthAwarePaginator $data, TransformerAbstract $transformer)
    {
        $fractal = new Manager();
        $resource = new Collection($data, $transformer);

        $paginatorAdapter = new IlluminatePaginatorAdapter($data);
        $resource->setPaginator($paginatorAdapter);

        return $fractal->createData($resource)->toArray()['data'];
    }

    protected function getDataForModel(AbstractModel $model, TransformerAbstract $transformer)
    {
        $fractal = new Manager();
        $item = new Item($model, $transformer);
        return $fractal->createData($item)->toArray()['data'];
    }


}
