<?php

namespace App\Services\User;

use App\Exceptions\MessageException;
use App\Repositories\UserRepository;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Log;
use App\Models\Role;
use Exception;

class UserServiceImp implements UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Paginate model
     *
     * @param int $perPage
     * @return mixed
     */
    public function paginate($perPage)
    {
        return $this->userRepository->paginate($perPage);
    }

    /**
     * Get all instances of model
     *
     * @return mixed
     */
    public function all()
    {
        return $this->userRepository->all();
    }

    /**
     * Create a new instance of model
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        if (!isset($data['role_id'])) {
            $memberRole = Role::where('name', 'member')->first();
            if ($memberRole) {
                $data['role_id'] = $memberRole->id;
            } else {
                throw new MessageException('Default role "member" not found');
            }
        }

        $data['password'] = bcrypt($data['password']);

        return $this->userRepository->create($data);
    }

    /**
     * Find a model by its primary key
     *
     * @param int $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->userRepository->find($id);
    }

    /**
     * Update the specified model in the database
     *
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, $id)
    {
        $user = $this->userRepository->find($id);

        if ($user) {
            $data['username'] = !empty($data['username']) ? $data['username'] : $user->name;
            $data['email'] = !empty($data['email']) ? $data['email'] : $user->email;
            $data['password'] = !empty($data['password']) ? bcrypt($data['password']) : $user->password;
            $data['first_name'] = !empty($data['first_name']) ? $data['first_name'] : $user->first_name;
            $data['last_name'] = !empty($data['last_name']) ? $data['last_name'] : $user->last_name;
            $data['avatar'] = !empty($data['avatar']) ? $data['avatar'] : $user->avatar;

            $data['role_id'] = !empty($data['role_id']) ? $data['role_id'] : $user->role_id;

            $this->userRepository->update($data, $id);
            return $user;
        } else {
            throw new MessageException('User not found');
        }
    }

    /**
     * Remove the specified model from the database
     *
     * @param int $id
     * @return mixed
     */
    public function delete($id)
    {
        if ($this->userRepository->isReferencedByHotel($id)) {
            throw new MessageException('Cannot delete this user because it is referenced by a hotel.');
        }
        $user = $this->userRepository->find($id);
        if ($user) {
            return $this->userRepository->delete($id);
        } else {
            throw new MessageException('User not found');
        }
    }

    /**
     * Update user profile
     *
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function updateProfile(array $data, $id)
    {
        $user = $this->userRepository->find($id);

        if ($user) {
            $data['username'] = !empty($data['username']) ? $data['username'] : $user->username;
            $data['email'] = !empty($data['email']) ? $data['email'] : $user->email;
            $data['password'] = !empty($data['password']) ? bcrypt($data['password']) : $user->password;
            $data['first_name'] = !empty($data['first_name']) ? $data['first_name'] : $user->first_name;
            $data['last_name'] = !empty($data['last_name']) ? $data['last_name'] : $user->last_name;
            $data['avatar'] = !empty($data['avatar']) ? $data['avatar'] : $user->avatar;
            $this->userRepository->update($data, $id);
            return $user;
        } else {
            throw new MessageException('User not found');
        }
    }
}
