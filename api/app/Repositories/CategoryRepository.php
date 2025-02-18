<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\BaseRepository;
use App\Contracts\Repositories\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Validator;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    function __construct(Category $model) {
        parent::__construct($model);
    }

    public function storeValidation(array $data)
    {
        return Validator::make($data, [
            'name' => 'required',
            'type' => 'required',
        ]);
    }

}