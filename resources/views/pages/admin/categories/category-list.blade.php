@extends('layouts.main-app')

@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body text-start">
                <h5 class="card-title">{{ __('categories list') }}</h5>
                <hr>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-9">
                            <form action="{{ route('admin.categories.list') }}" method="GET">
                                @csrf
                                <div class="row">
                                    <div class="w-auto input-group">
                                        <input type="text" class="border form-control-sm"
                                            placeholder="Recipient's categoryname" aria-label="Recipient's categoryname"
                                            aria-describedby="button-addon2" name="search_category"
                                            value="{{ old('search_category') ?? (Request::get('search_category') ?? '') }}">
                                        <button class="btn btn-sm border btn-outline-secondary" type="submit"
                                            id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col align-self-end">
                            <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal"
                                data-bs-target="#createNewCategoryModal" type="button"><span><i
                                        class="fa-solid fa-plus"></i></i></span>&nbsp;{{ __('New categories') }}</button>
                        </div>
                    </div>
                </div>
                <hr>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value=""
                                        onclick="toggleAllCheckboxes();" id="allcategoriesChecked">
                                    <label class="form-check-label" for="allcategoriesChecked">
                                        {{ __('All') }}
                                    </label>
                                </div>
                            </th>
                            <th scope="col">{{ __('categories code') }}</th>
                            <th scope="col">{{ __('categories name') }}</th>
                            <th class="text-center" scope="col">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody id="tbdcategoryList">
                        @isset($categories)
                            @php
                                $index = 0;
                            @endphp
                            @foreach ($categories as $category)
                                <tr>
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkbox{{ ++$index }}"
                                                value="{{ $category->id }}">
                                        </div>
                                    </th>
                                    <td>{{ $category->category_code }}</td>
                                    <td>{{ $category->category_name }}</td>
                                    <td class="text-center">
                                        <span>
                                            <a href="#"
                                                onclick="showcategory('{{ route('admin.categories.update', ['id' => $category->id]) }}', '{{ $category->category_code }}', '{{ $category->category_name }}', '{{ $category->category_description }}', '{{ $category->table_name }}', '{{ $category->status }}');
                                                "
                                                data-bs-toggle="modal" data-bs-target="#showCategoryModal"
                                                class="d-inline-flex focus-ring py-1 px-2 text-decoration-none border rounded-2"
                                                style="--bs-focus-ring-color: rgba(var(--bs-success-rgb), .25)">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                            @php
                                unset($index);
                            @endphp
                        @endisset

                    </tbody>
                </table>
                <div class="container overflow-hidden">
                    <div class="row gx-5">
                        <div class="col-sm col-xs">
                            <div class="justify-content-end">
                                <form id="formcategoryDelete" action="{{ route('admin.categories.destroy') }}"
                                    method="POST">
                                    @csrf
                                    @method('delete')
                                    <input id="inputListcategoryDelete" name="category_ids" type="text" hidden>
                                    <button onclick="deletecategories()" type="button"
                                        class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can"></i></button>
                                </form>

                            </div>
                        </div>
                        @isset($categories)
                            @php
                                $i = 0;
                                $totalPage = $categories->total();
                            @endphp
                            <div class="col-sm col-xs align-self-end">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-end">
                                        <li class="page-item">
                                            <a class="page-link sm" href="{{ $categories->previousPageUrl() }}">
                                                << </a>
                                        </li>

                                        @foreach ($categories->getUrlRange(1, $totalPage) as $link)
                                            <li class="page-item @if ($categories->currentPage() == ++$i) active @endif"><a
                                                    class="page-link sm" href="{{ $link }}">{{ $i }}</a>
                                            </li>
                                        @endforeach
                                        <li class="page-item">
                                            <a class="page-link sm" href="{{ $categories->nextPageUrl() }}">>></a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            @php
                                unset($i);
                            @endphp
                        @endisset

                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="createNewCategoryModal" tabindex="-1" aria-labelledby="createNewCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content  bg-dark-subtle">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createNewCategoryModalLabel">{{ __('New category') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('admin.categories.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="inputCategoryName" class="form-label">{{ __('category name') }}</label>
                            <input type="text" class="form-control" id="inputCategoryName" name="category_name"
                                placeholder="Enter category name">
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="selectCategoryTables"
                                            class="form-label">{{ __('Table name') }}</label>
                                        <select class="form-select" id="selectCategoryTables" name="table_name">
                                            @isset($tables)
                                                @foreach ($tables as $table)
                                                    <option value="{{ $table }}">{{ $table }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="inputCategoryStatus"
                                            class="form-label">{{ __('category status') }}</label>
                                        <div id="inputCategoryStatus" class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="inputStatusChecked" name="status" checked
                                                onchange="checkCategoryStatus(document.getElementById('inputStatusChecked'), document.getElementById('lableStatusChecked'))">
                                            &nbsp;
                                            <label id="lableStatusChecked" class="form-check-label"
                                                for="inputStatusChecked">{{ __('On') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="textareaCategoryDescriptions"
                                class="form-label">{{ __('Category description') }}</label>
                            <textarea class="form-control" id="textareaCategoryDescriptions" rows="3" name="category_description"
                                placeholder="Enter category description"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Create category') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="showCategoryModal" tabindex="-1" aria-labelledby="showCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content  bg-dark-subtle">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="showCategoryModalLabel">{{ __('category information') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formShowCategory" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="inputShowCategoryCode" class="form-label">{{ __('category code') }}</label>
                            <input type="text" class="form-control bg-primary-subtle border border-primary" id="inputShowCategoryCode" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="inputShowCategoryName" class="form-label">{{ __('category name') }}</label>
                            <input type="text" class="form-control" id="inputShowCategoryName" name="category_name"
                                placeholder="Enter category name">
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="selectShowCategoryTables"
                                            class="form-label">{{ __('Table name') }}</label>
                                        <select class="form-select" id="selectShowCategoryTables" name="table_name">
                                            @isset($tables)
                                                @foreach ($tables as $table)
                                                    <option value="{{ $table }}">{{ $table }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="inputCategoryStatus"
                                            class="form-label">{{ __('category status') }}</label>
                                        <div id="inputCategoryStatus" class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="inputShowStatusChecked" name="status" checked
                                                onchange="checkCategoryStatus(document.getElementById('inputShowStatusChecked'), document.getElementById('lableShowStatusChecked'))">
                                            &nbsp;
                                            <label id="lableShowStatusChecked" class="form-check-label"
                                                for="inputShowStatusChecked">{{ __('On') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="textareaShowCategoryDescriptions"
                                class="form-label">{{ __('Category description') }}</label>
                            <textarea class="form-control" id="textareaShowCategoryDescriptions" rows="3" name="category_description"
                                placeholder="Enter category description"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Update category') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('toast')
    @if (session('categorySuccess'))
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="liveToast" class="toast align-items-center border border-success border-3 bg-success"
                category="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('categorySuccess') }}
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
    @if ($errors->any() || session('categoryFalse'))
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="liveToast" class="toast align-items-center border border-danger border-3 bg-danger" category="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ $errors->first() ?? session('categoryFalse') }}
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
@endsection



@section('style-js')
    <script>
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(document.getElementById('liveToast'));
        toastBootstrap.show();

        function toggleAllCheckboxes() {
            var allcategoriesCheckbox = document.getElementById('allcategoriesChecked');
            var checkboxes = document.querySelectorAll(
                '#tbdcategoryList input[type="checkbox"]:not(#allcategoriesChecked)');

            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = allcategoriesCheckbox.checked;
            }
        }

        function deletecategories() {
            var tbody = document.getElementById('tbdcategoryList');
            var checkboxes = tbody.querySelectorAll('input[type="checkbox"]');
            var values = [];
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    values.push(checkboxes[i].value);
                }
            }

            if (values.length != 0) {
                document.getElementById('inputListcategoryDelete').value = values.join(',');
                document.getElementById('formcategoryDelete').submit();
            } else {
                alert('null values');
            }
        }

        function checkCategoryStatus(a, lableStatus) {
            if (a.checked) {
                lableStatus.innerHTML = "On";
            } else {
                lableStatus.innerHTML = "Off";
            }
        }

        function showcategory(action, categoryCode, categoryName, categoryDescriptions, categoryTable, categoryStatus) {
            document.getElementById('inputShowCategoryCode').value = categoryCode;
            document.getElementById('inputShowCategoryName').value = categoryName;
            document.getElementById('textareaShowCategoryDescriptions').value = categoryDescriptions;
            document.getElementById('inputShowStatusChecked').checked = (categoryStatus == true) ? true : false;
            checkCategoryStatus(document.getElementById('inputShowStatusChecked'), document.getElementById('lableShowStatusChecked'));

            var selectElement = document.getElementById('selectShowCategoryTables');
            var optionCount = selectElement.options.length;
            for (var i = 0; i < optionCount; i++) {
                var option = selectElement.options[i];
                if (option.value === categoryTable) {
                    option.selected = true;
                    break;
                }
            }
            document.getElementById('formShowCategory').action = action;
        }
    </script>
@endsection
