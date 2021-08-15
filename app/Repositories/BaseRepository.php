<?php

declare(strict_types=1);

namespace App\Repositories;

abstract class BaseRepository
{
    protected $modelClass;

    public function getById(int $id)
    {
        return app($this->modelClass)->find($id);
    }

    public function create(array $data)
    {
        return app($this->modelClass)->fill($data)->save();
    }

    public function update($model, array $data)
    {
        return $model->fill($data)->update();
    }
}
