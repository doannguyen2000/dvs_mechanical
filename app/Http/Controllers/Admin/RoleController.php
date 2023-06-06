<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\IndexRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    protected $roleRepository, $permissionRepository;

    public function __construct(RoleRepository $roleRepository, PermissionRepository $permissionRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    public function index(IndexRoleRequest $request)
    {
        try {
            $params = $request->validated();
            return view('pages.admin.roles.role-list', ['roles' => $this->roleRepository->getAll($params), 'permissions' => $this->permissionRepository->getAll(['permission_paginate' => '0'])]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Created new role False');
        }
    }

    public function store(CreateRoleRequest $request)
    {
        try {
            $params = $request->validated();
            $this->roleRepository->create($params);
            DB::commit();
            return redirect()->route('admin.roles.list')->with('success', 'Created new role success');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Created new role False');
        }
    }

    public function update(UpdateRoleRequest $request, $id)
    {
        try {
            $params = $request->validated();
            $message = $this->roleRepository->update($params, $id);
            DB::commit();
            if (!$message) return redirect()->back()->with('error', 'Role not foul!');
            return redirect()->route('admin.roles.list')->with('success', 'Updated new role success');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Updated new role False');
        }
    }

    public function destroy(Request $request)
    {
        try {
            $validator = Validator::make(['item_ids' => explode(',', $request->input('item_ids'))], [
                'item_ids.*' => ['required', Rule::exists('roles', 'id')],
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $params = $validator->validated();
            $this->roleRepository->destroy($params['item_ids']);
            DB::commit();
            return redirect()->route('admin.roles.list')->with('success', 'Delete role success');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Delete role False');
        }
    }
}
