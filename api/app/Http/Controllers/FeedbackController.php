<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\Crudable;
use App\Repositories\FeedbackRepository;
use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{
    use Crudable;

    public $repository;

    function __construct(FeedbackRepository $repository) {
        $this->repository = $repository;
    }

    public function createFeedback(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->input();
            $this->repository->storeValidation($data)->validate();
            $data['user_id'] = auth()->user()->id;
            $item = $this->repository->store($data);
            DB::commit();

            return response()->success("Feedback created successfully", compact("item"));

        } catch (\Exception $e) {
            DB::rollBack();
            DB::commit();
            return $this->handleException($e->getMessage());
        }
    }
}
