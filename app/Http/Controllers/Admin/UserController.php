<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\IndexUserRequest;
use App\Http\Requests\UpdateRoleUserRequest;
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

    public function show($id)
    {
        try {
            return view('pages.admin.users.user-show', ['user' => $this->userRepository->getById($id)]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Created new user False');
        }
    }

    public function update(UpdateUserRequest $request, $id)
    {

            $params = $request->validated();
            $this->userRepository->update($params, $id);
            DB::commit();
            return redirect()->back()->with('success', 'Created new user success');
      try {  } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Created new user False');
        }
    }

    public function destroy(Request $request)
    {
        try {
            $validator = Validator::make(['item_ids' => explode(',', $request->input('item_ids'))], [
                'item_ids.*' => ['required', Rule::exists('users', 'id')],
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $params = $validator->validated();
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
}
