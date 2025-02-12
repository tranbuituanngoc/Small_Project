<?php

namespace App\Services\Role;

use App\Repositories\RoleRepository;
use \Exception;

class RoleServiceImp implements RoleService
{
    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function all()
    {
        $this->roleRepository->all();
    }

    public function create($data)
    {
        if (!$this->checkAdminAndMemberRole()) {
            if ($this->roleRepository->find('name', $data->name)) {
                throw new Exception('The role name is already exist');
            }
            $this->roleRepository->create($data);
        }
        throw new Exception('Cannot create a new role if Admin and Member already exist.');
    }

    public function update($id, $data)
    {
        if ($this->roleRepository->find('name', $data->name)) {
            throw new Exception('The role name is already exist');
        }
        $this->roleRepository->update($id, $data);
    }

    public function delete($id)
    {
        if ($this->roleRepository->isReferencedByUser($id)) {
            throw new Exception('Cannot delete this role because it is referenced by a user.');
        }
        $this->roleRepository->delete($id);
    }

    public function find($id)
    {
        $this->roleRepository->find($id);
    }

    public function paginate($perPage)
    {
        $this->roleRepository->paginate($perPage);
    }

    /**
     * Check admin and member role is exist
     *
     * @param void
     * @return bool
     */
    private function checkAdminAndMemberRole()
    {
        $adminRole = $this->roleRepository->findBy('name', 'admin');
        $memberRole = $this->roleRepository->findBy('name', 'member');

        return !is_null($adminRole) && !is_null($memberRole);
    }
}
