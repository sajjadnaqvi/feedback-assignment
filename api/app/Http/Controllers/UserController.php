<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\Crudable;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    use Crudable;

    public $repository;

    function __construct(UserRepository $repository) {
        $this->repository = $repository;
    }

    public function getAuthenticatedUser(Request $request){
        try {
            $user = auth()->user();
            return response()->success("User fetch successfully", compact("user"));

        } catch (\Exception $e) {
            DB::rollBack();
            DB::commit();
            return $this->handleException($e->getMessage());
        }
    }
}
