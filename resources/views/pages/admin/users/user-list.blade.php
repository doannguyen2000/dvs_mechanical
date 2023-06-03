@extends('layouts.main-app')

@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body z-index-0 text-start">
                <h5 class="card-title">Users list</h5>
                <hr>
                <div class="container-fluid">
                    <div class="d-flex justify-content-between">
                        <form action="">
                            <div class="row border">
                                <div class="col">
                                    <div class="w-auto input-group">
                                        <input type="text" class="border form-control-sm" style="width: 70%"
                                            placeholder="Recipient's username" aria-describedby="button-addon2">
                                        <button class="btn btn-sm border btn-outline-secondary" style="width: 30%"
                                            type="button" id="button-addon2"><i
                                                class="fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                </div>
                                <div class="col">
                                    <select id="search-categoriess" class="form-select-sm"
                                        aria-label=".form-select-sm example">
                                        <option selected>All</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                    <select id="search-status" class="form-select-sm" aria-label=".form-select-sm example">
                                        <option selected>All</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                            </div>
                        </form>

                        <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal"
                            data-bs-target="#createNewUserModal" type="button"><span><i
                                    class="fa-solid fa-user-plus"></i></span><span class="span-text-new-item ml-3">{{ __('New account') }}</span></button>
                    </div>
                </div>
                <hr>

                <x-table-component :array-column-name="['category_code', 'category_name']" :array-column="['category_code', 'category_name']" :datas="$categories" :route-list="route('admin.categories.showUser')" :table="['id' => 'tableShowCategories', 'checkboxId' => 'inputCheckBoxCategories']"
                    :route-delete="[
                        'formId' => 'formDeleteCategories',
                        'formAction' => route('admin.categories.destroy'),
                        'inputId' => 'inputDeleteCategories',
                    ]">


                    <x-slot name="groupItemFunctions">
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
                    </x-slot>

                </x-table-component>

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
                                <input type="password" class="form-control" id="comfirm-password" name="comfirm_password"
                                    placeholder="Comfirm username">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Create user</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
