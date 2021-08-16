<?php

declare(strict_types=1);

namespace App\Repositories;

abstract class BaseRepository
{
    protected $modelClass;

    public function getById(int $modelId)
    {
        return app($this->modelClass)->find($modelId);
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
