<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function handleException($e)
    {
        $class_name = get_class($e);

        if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {

            return response()->error($e->getMessage(), $e->getStatusCode());

        } else if($class_name == "Illuminate\Validation\ValidationException"){

            return response()->error($e->getMessage(), 422, ["errors"=> $e->errors()]);

        } else if($class_name == "Illuminate\Database\Eloquent\ModelNotFoundException") {
            
            return response()->error("Record Not Found", Response::HTTP_NOT_FOUND);
        } else {

            return response()->error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
