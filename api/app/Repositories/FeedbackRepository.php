<?php

namespace App\Repositories;

use App\Models\Feedback;
use App\Repositories\BaseRepository;
use App\Contracts\Repositories\FeedbackRepositoryInterface;
use Illuminate\Support\Facades\Validator;

class FeedbackRepository extends BaseRepository implements FeedbackRepositoryInterface
{
    function __construct(Feedback $model) {
        parent::__construct($model);
    }

    public function storeValidation(array $data)
    { 
        return Validator::make($data, [
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
        ]);

    }
}