<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Support\Facades\Cache;

abstract class BaseRepository
{
    protected $modelClass;
    protected $cacheKey;

    public function getById(int $modelId)
    {
        return Cache::remember($this->cacheKey . $modelId, 180, function () use ($modelId) {
            return app($this->modelClass)->find($modelId);
        });
    }

    public function create(array $data)
    {
        $model = app($this->modelClass)->fill($data);
        $model->save();

        return $model->refresh();
    }

    public function update($model, array $data)
    {
        $model->fill($data)->update();
        return $model->refresh();
    }
}
