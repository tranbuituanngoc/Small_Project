<?php

namespace App\Repositories;

use App\Repositories\BaseRepositories\EloquentRepository;

class RoleRepository extends EloquentRepository
{
    /**
     * Get model.
     *
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Role::class;
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
    /**
     * Find model by column
     *
     * @param string $attribute
     * @param string $value
     * @return mixed
     */
    public function findBy($attribute, $value)
    {
        return $this->model->where($attribute, $value)->first();
    }
    /**
     * Paginate model
     *
     * @param int $perPage
     * @return mixed
     */
    public function paginate($perPage)
    {
        return $this->model->paginate($perPage);
    }

    /**
     * Check if this role is referenced by any user.
     *
     * @param int $id
     * @return bool
     */
    public function isReferencedByUser($id)
    {
        return $this->model->find($id)->users()->exists();
    }
}
