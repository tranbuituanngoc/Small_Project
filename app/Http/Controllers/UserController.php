<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\User\UserService;
use App\Services\Role\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Exception;

class UserController extends Controller
{
    protected $userService;
    protected $roleService;

    public function __construct(UserService  $userService, RoleService $roleService)
    {
        $this->userService  = $userService;
        $this->roleService = $roleService;
    }

    public function index()
    {
        $perPage = config('app.per_page');
        $users = $this->userService->paginate($perPage);
        return view('user.index', compact('users'));
    }

    public function create()
    {
        $roles  = $this->roleService->all();

        return view('user.create', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('avatar')) {
                $avatarName = Str::uuid() . '.' . $request->avatar->extension();
                $request->avatar->move(public_path('images'), $avatarName);
                $data['avatar'] = $avatarName;
            } else {
                $data['avatar'] = 'default_avatar.png';
            }

            $this->userService->create($data);

            return redirect()->route('user.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error("Create User Error: " . $e->getMessage());
            return redirect()->route('user.create');
        }
    }

    public function edit($id)
    {
        $user = $this->userService->find($id);
        $roles  = $this->roleService->all();
        return view('user.edit', compact('user', 'roles'));
    }

    public function update(UserRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $user = $this->userService->find($id);

            if ($request->hasFile('avatar')) {
                if ($user->avatar) {
                    Storage::delete('public/images/' . $user->avatar);
                }
                $avatarName = Str::uuid() . '.' . $request->avatar->extension();
                $request->avatar->move(public_path('images'), $avatarName);
                $data['avatar'] = $avatarName;
            }

            $this->userService->update($data, $id);

            return redirect()->route('user.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('user.edit', $id);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('user.edit', $id);
        }
    }

    public function destroy($id)
    {
        try {
            $this->userService->delete($id);

            return redirect()->route('user.index');
        } catch (\Exception $e) {
            return redirect()->route('user.index');
        }
    }
}
