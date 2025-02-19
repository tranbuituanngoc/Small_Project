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
        $this->middleware('checkUserRole:ADMIN');
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

            return redirect()->route('user.index')
                ->with('success', __('messages.user_created_successfully'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error("Create User Error: " . $e->getMessage());
            return redirect()->route('user.create')
                ->with('error', __('messages.user_create_error'));
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

            return redirect()->route('user.index')
                ->with('success', __('messages.user_updated_successfully'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('user.edit', $id)
                ->with('error', __('messages.user_update_error'));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('user.edit', $id)
                ->with(
                    'error',
                    ('messages.user_update_error')
                );
        }
    }

    public function destroy($id)
    {
        try {
            $user = $this->userService->find($id);
            Log::info(1);
            if ($user->hotels()->count() > 0) {
                Log::info(2);
                return redirect()->route('user.index')
                    ->with('error', __('messages.user_assigned_to_hotels'));
            }
            Log::info(3);
            $this->userService->delete($id);

            return redirect()->route('user.index')
                ->with('success', __('messages.user_deleted_successfully'));
        } catch (\Exception $e) {
            return redirect()->route('user.index')
                ->with('error', __('messages.user_delete_error'));
        }
    }
}
