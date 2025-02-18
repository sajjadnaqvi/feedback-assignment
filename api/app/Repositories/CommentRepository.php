<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\BaseRepository;
use App\Contracts\Repositories\CommentRepositoryInterface;
use Illuminate\Support\Facades\Validator;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    function __construct(Comment $model) {
        parent::__construct($model);
    }

    public function getComment($id,$type ='Feedback')
    {
        return $this->model::listingInfo()->where([['commentable_id',$id],['commentable_type',$type]])->get();
    }
    
    public function storeValidation(array $data)
    { 
        return Validator::make($data, [
            'commentable_id' => 'required',
            'commentable_type' => 'required',
            'content' => 'required',
        ]);

    }

    // public function updateValidation(array $data)
    // {
    //     return Validator::make($data, [
            
    //     ]);

    // }
}