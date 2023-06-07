<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\DestroyUserRequest;
use App\Http\Requests\IndexUserRequest;
use App\Http\Requests\ShowUserRequest;
use App\Http\Requests\UpdateRoleUserRequest;
use App\Http\Requests\updateStatusUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    protected $roleRepository, $userRepository;

    public function __construct(RoleRepository $roleRepository, UserRepository $userRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->userRepository = $userRepository;
    }

    public function index(IndexUserRequest $request)
    {
        try {
            $params = $request->validated();
            return view('pages.admin.users.user-list', ['users' => $this->userRepository->getAll($params), 'roles' => $this->roleRepository->getAll(['paginate' => 0])]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Created new user False');
        }
    }

    public function store(CreateUserRequest $request)
    {
        try {
            $params = $request->validated();
            $this->userRepository->create($params);
            DB::commit();
            return redirect()->back()->with('success', 'Created new user success');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Created new user False');
        }
    }

    public function show(ShowUserRequest $request, $id)
    {
        try {
            $params = $request->validated();
            return view('pages.admin.users.user-show', ['user' => $this->userRepository->getById($id), 'showModal' => $params['show_modal'] ?? false]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Created new user False');
        }
    }

    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $params = $request->validated();
            $this->userRepository->update($params, $id);
            DB::commit();
            return redirect()->back()->with('success', 'Created new user success');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Created new user False');
        }
    }

    public function destroy(DestroyUserRequest $request)
    {
        try {
            $params = $request->validated();
            $this->userRepository->destroy($params['item_ids']);
            DB::commit();
            return redirect()->back()->with('success', 'Delete user success');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Delete user False');
        }
    }

    public function updateRoleUser(UpdateRoleUserRequest $request, $id)
    {
        try {
            $params = $request->validated();
            $this->userRepository->updateRoleUser($params, $id);
            DB::commit();
            return redirect()->back()->with('success', 'Update role user success');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Delete user False');
        }
    }

    public function updateStatusUser(updateStatusUserRequest $request)
    {
        try {
            $params = $request->validated();
            $this->userRepository->updateStatusUser($params);
            DB::commit();
            return redirect()->back()->with('success', 'Update status user success');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Update status user False');
        }
    }
}
