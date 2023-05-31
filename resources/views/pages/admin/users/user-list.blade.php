@extends('layouts.main-app')

@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body z-index-0 text-start">
                <h5 class="card-title">Users list</h5>
                <hr>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="row">
                                <div class="w-auto input-group">
                                    <input type="text" class="border form-control-sm" placeholder="Recipient's username"
                                        aria-label="Recipient's username" aria-describedby="button-addon2">
                                    <button class="btn btn-sm border btn-outline-secondary" type="button"
                                        id="button-addon2">Button</button>
                                </div>
                                <select id="search-roles" class="col-lg-3 col-md-3 form-select-sm"
                                    aria-label=".form-select-sm example">
                                    <option selected>All roles</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                                <select id="search-status" class="col-lg-3 col-md-3 form-select-sm"
                                    aria-label=".form-select-sm example">
                                    <option selected>All status</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>
                        <div class="col align-self-end">
                            <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal"
                                data-bs-target="#createNewUserModal" type="button"><span><i
                                        class="fa-solid fa-user-plus"></i></span>&nbsp;New account</button>
                        </div>
                    </div>
                </div>
                <hr>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="allUsersChecked">
                                    <label class="form-check-label" for="allUsersChecked">
                                        all
                                    </label>
                                </div>
                            </th>
                            <th scope="col">Avatar</th>
                            <th scope="col">Username</th>
                            <th scope="col">Role</th>
                            <th scope="col">Status</th>
                            <th class="text-center" scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="">
                                </div>
                            </th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>Otto</td>
                            <td class="text-center">
                                <span>
                                    <a href="{{ route('admin.users.show', ['id' => 1]) }}"
                                        class="d-inline-flex focus-ring py-1 px-2 text-decoration-none border rounded-2"
                                        style="--bs-focus-ring-color: rgba(var(--bs-success-rgb), .25)">
                                        <i class="fa-solid fa-chalkboard-user"></i>
                                    </a>
                                </span>
                                &nbsp;
                                <span>
                                    <a href="#"
                                        class="d-inline-flex focus-ring py-1 px-2 text-decoration-none border rounded-2"
                                        style="--bs-focus-ring-color: rgba(var(--bs-success-rgb), .25)">
                                        <i class="fa-solid fa-user-large-slash" style="color: #e43307;"></i>
                                    </a>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="container overflow-hidden">
                    <div class="row gx-5">
                        <div class="col-sm col-xs">
                            <div class="justify-content-end">
                                <button type="button" class="btn btn-sm btn-outline-warning"><i
                                        class="fa-solid fa-user-lock"></i></button>
                                <button type="button" class="btn btn-sm btn-outline-danger"><i
                                        class="fa-solid fa-trash-can"></i></button>
                            </div>
                        </div>
                        <div class="col-sm col-xs align-self-end">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end">
                                    <li class="page-item disabled">
                                        <a class="page-link sm">
                                            << </a>
                                    </li>
                                    <li class="page-item"><a class="page-link sm" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link sm" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link sm" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link sm" href="#">>></a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="createNewUserModal" tabindex="-1" aria-labelledby="createNewUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content  bg-dark-subtle">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createNewUserModalLabel">New user</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row mb-3">
                            <label for="username" class="col-sm-3 col-form-label">Username</label>
                            <div class="col-sm-9">
                                <input type="text" value="{{ old('name') }}" class="form-control" id="username"
                                    name="name" placeholder="Emter username">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" value="{{ old('email') }}" class="form-control" id="email"
                                    name="email" placeholder="Emter email">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password" class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                                <input type="password" value="{{ old('password') }}" class="form-control" id="password"
                                    name="password" placeholder="Emter password">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="comfirm-password" class="col-sm-3 col-form-label">Re Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="comfirm-password"
                                    name="comfirm_password" placeholder="Comfirm username">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Create user</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
