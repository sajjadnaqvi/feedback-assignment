<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\Crudable;
use App\Repositories\CommentRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    use Crudable;

    public $repository;

    function __construct(CommentRepository $repository) {
        $this->repository = $repository;
    }

    public function createComment(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->input();
            $this->repository->storeValidation($data)->validate();
            $data['user_id'] = auth()->user()->id;
            $data['date'] = Carbon::now();
            $comment = $this->repository->store($data);

            if(!empty( $data['mention_ids'])) {
                $comment->mentions()->attach($data['mention_ids']);
            }
            $item = $this->repository->getSingle($comment->id);

            DB::commit();

            return response()->success("Feedback created successfully", compact("item"));

        } catch (\Exception $e) {
            DB::rollBack();
            DB::commit();
            return $this->handleException($e->getMessage());
        }
    }

    public function getFeedbackComments($id)
    {
        try {
            DB::beginTransaction();
            $comments = $this->repository->getComment($id);


            DB::commit();

            return response()->success("Comments fetch successfully", compact("comments"));

        } catch (\Exception $e) {
            DB::rollBack();
            DB::commit();
            // return $this->handleException($e->getMessage());
            return $e;
        }
    }
    
}
