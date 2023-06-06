<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePermissionRequest;
use App\Http\Requests\IndexPermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Repositories\PermissionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
            return redirect()->route('admin.permissions.list')->with('success', 'Updated new permission success');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Updated new permission False');
        }
    }

    public function destroy(Request $request)
    {
        try {
            $validator = Validator::make(['item_ids' => explode(',', $request->input('item_ids'))], [
                'item_ids.*' => ['required', Rule::exists('permissions', 'id')],
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $params = $validator->validated();
            $this->permissionRepository->destroy($params['item_ids']);
            DB::commit();
            return redirect()->route('admin.permissions.list')->with('success', 'Delete permission success');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Delete permission False');
        }
    }
}
