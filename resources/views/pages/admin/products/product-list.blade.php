@extends('layouts.main-app')

@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body z-index-0 text-start">
                <h5 class="card-title">Products list</h5>
                <hr>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="row">
                                <div class="w-auto input-group">
                                    <input type="text" class="border form-control-sm"
                                        placeholder="Recipient's Productname" aria-label="Recipient's Productname"
                                        aria-describedby="button-addon2">
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
                            <a class="btn btn-sm btn-outline-success" href="{{route('admin.products.new')}}"><span><i class="fa-solid fa-plus"></i></span>&nbsp;New product</a>
                        </div>
                    </div>
                </div>
                <hr>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="allProductsChecked">
                                    <label class="form-check-label" for="allProductsChecked">
                                        all
                                    </label>
                                </div>
                            </th>
                            <th scope="col">Avatar</th>
                            <th scope="col">Productname</th>
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
                                    <a href="{{ route('admin.products.show', ['id' => 1]) }}"
                                        class="d-inline-flex focus-ring py-1 px-2 text-decoration-none border rounded-2"
                                        style="--bs-focus-ring-color: rgba(var(--bs-success-rgb), .25)">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </span>
                                &nbsp;
                                <span>
                                    <a href="#"
                                        class="d-inline-flex focus-ring py-1 px-2 text-decoration-none border rounded-2"
                                        style="--bs-focus-ring-color: rgba(var(--bs-success-rgb), .25)">
                                        <i class="fa-solid fa-trash-can" style="color: #e43307;"></i>
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
