<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    public $model;

    function __construct(Model $model ) {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function paginate($perPage = null)
    {
        return $this->model->paginate($perPage);
    }

    public function create(array $data = [])
    {
        return $this->model->create($data);
    }

    public function store(array $data)
    {
        return $this->create($data);
    }

    public function update(array $data = [], $id)
    {
        $instance = $this->findOrFail($id);
        $instance->fill($data);
        $instance->save();
        return $instance;
    }

    public function delete($id)
    {
        $model = $this->findOrFail($id);
        $model->delete();
    }

    public function getSingle($id)
    {
        return $this->model::singleInfo()->findorfail($id);
    }

    public function getPaginated($data = [])
    {
        $pagination_length = $data["page_size"] ?? 10;
        $query = $this->model::listingInfo()->filters($data);

        //Boolean: checking Is model has timestamps `true or false`
        $this->model->timestamps ? $query->latest() : $query->latest("id");

        return $query->paginate($pagination_length);
    }
    
}