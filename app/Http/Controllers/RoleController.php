<?php

namespace App\Http\Controllers;

use App\Services\Role\RoleService;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\Log;
use Exception;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
        $this->middleware('checkUserRole:ADMIN');
    }

    public function index()
    {
        $perPage = config('app.per_page');
        $roles =  $this->roleService->paginate($perPage);

        $adminAndMemberExist = $this->roleService->checkAdminAndMemberRole();

        return view('role.index', compact('roles', 'adminAndMemberExist'));
    }

    public function create()
    {
        return view('role.create');
    }

    public function store(RoleRequest $request)
    {
        try {
            $data = $request->validated();
            $this->roleService->create($data);
            return redirect()->route('role.index')->with('success', __('messages.role_created_successfully'));
        } catch (\Exception $e) {
            Log::error("Create Role Error: " . $e->getMessage());
            return redirect()->back()->with('error', __('messages.role_create_error'));
        }
    }

    public function edit($id)
    {
        $role = $this->roleService->find($id);
        return view('role.edit', compact('role'));
    }

    public function update(RoleRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $this->roleService->update($data, $id);
            return redirect()->route('role.index')->with('success', __('messages.role_updated_successfully'));
        } catch (\Exception $e) {
            Log::error("Update Role Error: " . $e->getMessage());
            return redirect()->back()->with('error', __('messages.role_update_error'));
        }
    }

    public function destroy($id)
    {
        try {
            $role = $this->roleService->find($id);

            if ($role->users()->count() > 0) {
                return redirect()->route('role.index')->with('error', __('messages.role_assigned_to_users'));
            }

            $this->roleService->delete($id);

            return redirect()->route('role.index')->with('success', __('messages.role_deleted_successfully'));
        } catch (Exception $e) {
            Log::error("Delete Role Error: " . $e->getMessage());
            return redirect()->route('role.index')->with('error', __('messages.role_delete_error'));
        }
    }
}
