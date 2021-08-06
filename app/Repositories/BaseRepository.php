<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->get();
    }


    public function save(Model $model)
    {
        $model->save();
    }

    public function update(Model $model)
    {
        $model->update();
    }

    public function delete(Model $model)
    {
        $model->delete();
    }

}