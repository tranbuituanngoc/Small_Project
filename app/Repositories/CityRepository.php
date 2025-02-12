<?php

namespace App\Repositories;

use App\Models\City;
use App\Repositories\BaseRepositories\EloquentRepository;

class CityRepository extends EloquentRepository
{
    /**
     * Get model.
     *
     * @return string
     */
    public function getModel()
    {
        return City::class;
    }

    public function findBy($attribute, $value)
    {
        return $this->model->where($attribute, $value)->first();
    }
    /**
     * Get model by id
     *
     * @param int $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->model->find($id);
    }
}
