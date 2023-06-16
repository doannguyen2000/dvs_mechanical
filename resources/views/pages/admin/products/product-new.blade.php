@extends('layouts.main-app')

@section('content')
    <div class="container">
        <div class="card mt-4 bg-body-tertiary">
            <div class="card-body z-index-0 text-start">
                <h5 class="card-title">Products list</h5>
                <hr>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Product information</h5>
                        <div class="row container border mb-3">
                            <div class="col-md-4 col-sm-3 text-center">
                                <img src="{{ asset('assets/images/download.png') }}" class="img-thumbnail" alt="...">
                            </div>
                            <div class="col-md-8 col-sm-9 border">
                                <div class="row">
                                    <div class="col-md-3 col-sm-6 col-xs-6 mb-3">
                                        <div class="w-auto position-relative">
                                            <img src="{{ asset('assets/images/download.png') }}"
                                                class="img-thumbnail border rounded-2" alt="...">
                                            <a href="#"
                                                class="d-inline-flex focus-ring py-1 px-2 text-decoration-none border rounded-2 position-absolute top-0 end-0"
                                                style="--bs-focus-ring-color: rgba(var(--bs-success-rgb), .25)">
                                                <i class="fa-solid fa-square-minus text-danger"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-sm-6 col-xs-6 mb-3">
                                        <div class="w-auto position-relative">
                                            <img src="{{ asset('assets/images/download.png') }}"
                                                class="img-thumbnail border rounded-2" alt="...">
                                            <a href="#"
                                                class="d-inline-flex focus-ring py-1 px-2 text-decoration-none border rounded-2 position-absolute top-0 end-0"
                                                style="--bs-focus-ring-color: rgba(var(--bs-success-rgb), .25)">
                                                <i class="fa-solid fa-square-minus text-danger"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-sm-6 col-xs-6 mb-3">
                                        <div class="w-auto position-relative">
                                            <img src="{{ asset('assets/images/download.png') }}"
                                                class="img-thumbnail border rounded-2" alt="...">
                                            <a href="#"
                                                class="d-inline-flex focus-ring py-1 px-2 text-decoration-none border rounded-2 position-absolute top-0 end-0"
                                                style="--bs-focus-ring-color: rgba(var(--bs-success-rgb), .25)">
                                                <i class="fa-solid fa-square-minus text-danger"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-sm-6 col-xs-6 mb-3">
                                        <div class="w-auto position-relative">
                                            <img src="{{ asset('assets/images/download.png') }}"
                                                class="img-thumbnail border rounded-2" alt="...">
                                            <a href="#"
                                                class="d-inline-flex focus-ring py-1 px-2 text-decoration-none border rounded-2 position-absolute top-0 end-0"
                                                style="--bs-focus-ring-color: rgba(var(--bs-success-rgb), .25)">
                                                <i class="fa-solid fa-square-minus text-danger"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-sm-6 col-xs-6 mb-3">
                                        <div class="w-auto position-relative">
                                            <img src="{{ asset('assets/images/download.png') }}"
                                                class="img-thumbnail border rounded-2" alt="...">
                                            <a href="#"
                                                class="d-inline-flex focus-ring py-1 px-2 text-decoration-none border rounded-2 position-absolute top-0 end-0"
                                                style="--bs-focus-ring-color: rgba(var(--bs-success-rgb), .25)">
                                                <i class="fa-solid fa-square-minus text-danger"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-sm-6 col-xs-6 mb-3">
                                        <div class="w-auto position-relative">
                                            <img src="{{ asset('assets/images/download.png') }}"
                                                class="img-thumbnail border rounded-2" alt="...">
                                            <a href="#"
                                                class="d-inline-flex focus-ring py-1 px-2 text-decoration-none border rounded-2 position-absolute top-0 end-0"
                                                style="--bs-focus-ring-color: rgba(var(--bs-success-rgb), .25)">
                                                <i class="fa-solid fa-square-minus text-danger"></i>
                                            </a>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <form class="row g-3">
                            <div class="col-sm-12">
                                <label for="inputProductName" class="form-label">Product name</label>
                                <input type="text" class="form-control" id="inputProductName" name="product_name">
                            </div>
                            <div class="col-sm-6">
                                <label for="selectProductType" class="form-label">Product type</label>
                                <select class="form-select" aria-label="Default select example" name="product_type"
                                    id="selectProductType">
                                    <option selected>Open this select menu</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="selectProductCategory" class="form-label">Product category</label>
                                <select class="form-select" aria-label="Default select example" name="product_category"
                                    id="selectProductCategory">
                                    <option selected>Open this select menu</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="col-sm-12">
                                <label for="inputProductPrice" class="form-label">Product price</label>
                                <input type="number" min="100000" value="100000" class="form-control" id="inputProductPrice" name="product_price">
                            </div>
                            <div class="col-sm-12">
                                <label for="inputProductSale" class="form-label">Product sale</label>
                                <input type="number" min="0" value="0" max="100" class="form-control" id="inputProductSale" name="product_sale">
                            </div>
                            <div class="col-sm-12">
                                <label for="textareaProductDescription" class="form-label">Product description</label>
                                <textarea class="form-control" id="textareaProductDescription" rows="3" name="product_description"></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
