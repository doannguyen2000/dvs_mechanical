<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePermissionRequest;
use App\Http\Requests\DestroyPermissionRequest;
use App\Http\Requests\IndexPermissionRequest;
use App\Http\Requests\ShowUserRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Repositories\PermissionRepository;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    protected $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function index(IndexPermissionRequest $request)
    {
        try {
            $params = $request->validated();
            return view('pages.admin.permissions.permission-list', ['permissions' => $this->permissionRepository->getAll($params)]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Created new permission False');
        }
    }

    public function show(ShowUserRequest $request, $id)
    {
        try {
            $params = $request->validated();
            return view('pages.admin.permissions.permission-show', ['permission' => $this->permissionRepository->getById($id), 'showModal' => $params['show_modal'] ?? false]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Show permission False');
        }
    }

    public function store(CreatePermissionRequest $request)
    {
        try {
            $params = $request->validated();
            $this->permissionRepository->create($params);
            DB::commit();
            return redirect()->route('admin.permissions.list')->with('success', 'Created new permission success');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Created new permission False');
        }
    }

    public function update(UpdatePermissionRequest $request, $id)
    {
        try {
            $params = $request->validated();
            $message = $this->permissionRepository->update($params, $id);
            DB::commit();
            if (!$message) return redirect()->back()->with('error', 'permission not foul!');
            return redirect()->back()->with('success', 'Updated new permission success');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Updated new permission False');
        }
    }

    public function destroy(DestroyPermissionRequest $request)
    {
        try {
            $params = $request->validated();
            $this->permissionRepository->destroy($params['item_ids']);
            DB::commit();
            return redirect()->route('admin.permissions.list')->with('success', 'Delete permission success');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Delete permission False');
        }
    }
}
