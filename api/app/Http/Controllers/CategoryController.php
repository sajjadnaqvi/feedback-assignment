<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\Crudable;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    use Crudable;

    public $repository;

    function __construct(CategoryRepository $repository) {
        $this->repository = $repository;
    }
}
