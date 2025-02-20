<?php

namespace App\Services\Role;

use App\Repositories\RoleRepository;
use \Exception;
use App\Exceptions\MessageException;
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
        if (!$this->checkAdminAndMemberRole()) {
            $this->roleRepository->create($data);
        } else {
            throw new MessageException('Cannot create a new role if Admin and Member already exist.');
        }
    }

    public function update($id, $data)
    {
        $role = $this->roleRepository->find($id);
        if ($role) {
            $this->roleRepository->update($id, $data);
        } else {
            throw new MessageException('Role not found');
        }
    }

    public function delete($id)
    {
        if ($this->roleRepository->isReferencedByUser($id)) {
            throw new MessageException('Cannot delete this role because it is referenced by a user.');
        }
        $role = $this->roleRepository->find($id);
        if ($role) {
            $this->roleRepository->delete($id);
        } else {
            throw new MessageException('Role not found');
        }
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
