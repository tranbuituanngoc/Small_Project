<?php

namespace App\Services\Role;

interface RoleService
{
    public function all();
    public function create(array $data);
    public function update(array $data, $id);
    public function delete($id);
    public function find($id);
    public function paginate($perPage);
    public function checkAdminAndMemberRole();
}
