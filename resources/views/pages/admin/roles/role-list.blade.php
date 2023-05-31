@extends('layouts.main-app')

@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body z-index-0 text-start">
                <h5 class="card-title">roles list</h5>
                <hr>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="row">
                                <div class="w-auto input-group">
                                    <input type="text" class="border form-control-sm" placeholder="Recipient's rolename"
                                        aria-label="Recipient's rolename" aria-describedby="button-addon2">
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
                                data-bs-target="#createNewRoleModal" type="button"><span><i
                                        class="fa-solid fa-role-plus"></i></span>&nbsp;New Role</button>
                        </div>
                    </div>
                </div>
                <hr>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="allrolesChecked">
                                    <label class="form-check-label" for="allrolesChecked">
                                        all
                                    </label>
                                </div>
                            </th>
                            <th scope="col">Avatar</th>
                            <th scope="col">rolename</th>
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
                                    <a href="#"
                                        class="d-inline-flex focus-ring py-1 px-2 text-decoration-none border rounded-2"
                                        style="--bs-focus-ring-color: rgba(var(--bs-success-rgb), .25)">
                                        <i class="fa-solid fa-role-large-slash" style="color: #e43307;"></i>
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
    <div class="modal fade" id="createNewRoleModal" tabindex="-1" aria-labelledby="createNewRoleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content  bg-dark-subtle">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createNewRoleModalLabel">New role</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="inputRoleName" class="form-label">Role name</label>
                            <input type="email" class="form-control" id="inputRoleName" name="role_name" placeholder="name@example.com">
                          </div>
                          <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                          </div>
                        <button type="submit" class="btn btn-primary">Create role</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
