<?php

namespace App\Services\Role;

use App\Repositories\RoleRepository;
use \Exception;
use Illuminate\Support\Facades\Log;

class RoleServiceImp implements RoleService
{
    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function all()
    {
        return  $this->roleRepository->all();
    }

    public function create($data)
    {
        Log::info('Check: ' . $this->checkAdminAndMemberRole());
        if (!$this->checkAdminAndMemberRole()) {
            if ($this->roleRepository->find('name', $data['name'])) {
                throw new Exception('The role name is already exist');
            }
            $this->roleRepository->create($data);
        } else {
            throw new Exception('Cannot create a new role if Admin and Member already exist.');
        }
    }

    public function update($id, $data)
    {
        $role = $this->roleRepository->find($id);
        if ($role) {
            if (isset($data['name']) && $this->roleRepository->find('name', $data['name'])) {
                throw new Exception('The role name is already exist');
            }
            $this->roleRepository->update($id, $data);
        } else {
            throw new Exception('Role not found');
        }
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
        return $this->roleRepository->find($id);
    }

    public function paginate($perPage)
    {
        return  $this->roleRepository->paginate($perPage);
    }

    /**
     * Check admin and member role is exist
     *
     * @param void
     * @return bool
     */
    public function checkAdminAndMemberRole()
    {
        $adminRole = $this->roleRepository->findBy('name', 'admin');
        $memberRole = $this->roleRepository->findBy('name', 'member');

        return !is_null($adminRole) && !is_null($memberRole);
    }
}
