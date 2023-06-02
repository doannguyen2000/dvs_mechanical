@extends('layouts.main-app')

@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body text-start">
                <h5 class="card-title">{{ __('Permissions list') }}</h5>
                <hr>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-9">
                            <form action="{{ route('admin.permissions.list') }}" method="GET">
                                @csrf
                                <div class="row">
                                    <div class="w-auto input-group">
                                        <input type="text" class="border form-control-sm"
                                            placeholder="Recipient's permissionname" aria-label="Recipient's permissionname"
                                            aria-describedby="button-addon2" name="permission_search"
                                            value="{{ old('permission_search') ?? (Request::get('permission_search') ?? '') }}">
                                        <button class="btn btn-sm border btn-outline-secondary" type="submit"
                                            id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col align-self-end">
                            <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal"
                                data-bs-target="#createNewpermissionModal" type="button"><span><i
                                        class="fa-solid fa-plus"></i></i></span>&nbsp;{{ __('New permissions') }}</button>
                        </div>
                    </div>
                </div>
                <hr>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" onclick="checkAllClick()"
                                        id="allPermissionsChecked">
                                    <label class="form-check-label" for="allPermissionsChecked">
                                        {{ __('All') }}
                                    </label>
                                </div>
                            </th>
                            <th scope="col">{{ __('Permissions code') }}</th>
                            <th scope="col">{{ __('Permissions name') }}</th>
                            <th class="text-center" scope="col">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody id="tbdPermissionList">
                        @isset($permissions)
                            @php
                                $index = 0;
                            @endphp
                            @foreach ($permissions as $permission)
                                <tr>
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkbox{{ ++$index }}"
                                                value="{{ $permission->id }}">
                                        </div>
                                    </th>
                                    <td>{{ $permission->permission_code }}</td>
                                    <td>{{ $permission->permission_name }}</td>
                                    <td class="text-center">
                                        <span>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#showpermissionModal"
                                                class="d-inline-flex focus-ring py-1 px-2 text-decoration-none border rounded-2"
                                                style="--bs-focus-ring-color: rgba(var(--bs-success-rgb), .25)"
                                                onclick="showpermission('{{ route('admin.permissions.update', ['id' => $permission->id]) }}','{{ $permission->permission_code }}','{{ $permission->permission_name }}','{{ $permission->permission_icon }}')">
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
                <div class="container">
                    <div class="row gx-5">
                        <div class="col-sm col-xs">
                            <div class="w-auto">
                                <form hidden id="formPermissionFunction" action="{{ route('admin.permissions.destroy') }}">
                                    @csrf
                                    <input id="inputPermissionFunction" type="text" hidden>
                                </form>
                                <button
                                    onclick="deleteItem(document.getElementById('tbdPermissionList'), document.getElementById('formPermissionFunction'), document.getElementById('inputPermissionFunction'), 'permission_ids', '{{ route('admin.permissions.destroy') }}', 'post');"
                                    type="button" style="display: inline-block;" class="btn btn-sm btn-outline-danger"><i
                                        class="fa-solid fa-trash-can"></i></button>
                                <select class="form-select-sm form-select m-0" id="selectPermissionPaginate"
                                    style="width: 75px;display: inline-block" aria-label="Default select example"
                                    onchange=" paginateItem(document.getElementById('formPermissionFunction'), 'permission_paginate', document.getElementById('inputPermissionFunction'), document.getElementById('selectPermissionPaginate'),'{{ route('admin.permissions.list') }}', 'get')">
                                    <option @if (Request::get('permission_paginate' == null) || Request::get('permission_paginate') == '5') selected @endif value="5">5</option>
                                    <option @if (Request::get('permission_paginate') == '10') selected @endif value="10">10</option>
                                    <option @if (Request::get('permission_paginate') == '20') selected @endif value="20">20</option>
                                    <option @if (Request::get('permission_paginate') == '50') selected @endif value="50">50</option>
                                    <option @if (Request::get('permission_paginate') == '100') selected @endif value="100">100</option>
                                    <option @if (Request::get('permission_paginate') == '0') selected @endif value="0">All</option>
                                </select>
                            </div>

                        </div>
                        @if (Request::get('permission_paginate') !== '0')
                            @isset($permissions)
                                @php
                                    $i = 0;
                                @endphp
                                <div class="col-sm col-xs align-self-end">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination justify-content-end">
                                            <li class="page-item">
                                                <a class="page-link sm" href="{{ $permissions->previousPageUrl() }}">
                                                    << </a>
                                            </li>

                                            @foreach ($permissions->getUrlRange(1, $permissions->lastPage()) as $link)
                                                <li class="page-item @if ($permissions->currentPage() == ++$i) active @endif"><a
                                                        class="page-link sm"
                                                        href="{{ $link }}">{{ $i }}</a>
                                                </li>
                                            @endforeach
                                            <li class="page-item">
                                                <a class="page-link sm" href="{{ $permissions->nextPageUrl() }}">>></a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                                @php
                                    unset($i);
                                @endphp
                            @endisset
                        @endif


                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="createNewpermissionModal" tabindex="-1" aria-labelledby="createNewpermissionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content  bg-dark-subtle">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createNewpermissionModalLabel">{{ __('New permission') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('admin.permissions.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="inputpermissionName" class="form-label">{{ __('Permission name') }}</label>
                            <input type="text" class="form-control" id="inputpermissionName" name="permission_name"
                                placeholder="Enter permission name">
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Create permission') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="showpermissionModal" tabindex="-1" aria-labelledby="showpermissionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content  bg-dark-subtle">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="showpermissionModalLabel">{{ __('Permission information') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formShowPermission" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="inputShowPermissionCode" class="form-label">{{ __('Permission code') }}</label>
                            <input type="text" class="form-control" id="inputShowPermissionCode" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="inputShowPermissionName" class="form-label">{{ __('Permission name') }}</label>
                            <input type="text" class="form-control" id="inputShowPermissionName"
                                name="permission_name" placeholder="Enter permission name">
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Update permission') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('toast')
    @if (session('permissionSuccess'))
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="liveToast" class="toast align-items-center border border-success border-3 bg-success"
                permission="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('permissionSuccess') }}
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
    @if ($errors->any() || session('permissionFalse'))
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="liveToast" class="toast align-items-center border border-danger border-3 bg-danger"
                permission="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ $errors->first() ?? session('permissionFalse') }}
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

        function checkAllClick() {
            toggleAllCheckboxes(document.getElementById("allPermissionsChecked"), document.querySelectorAll(
                "#tbdPermissionList input[type='checkbox']:not(#allPermissionsChecked)"));
        }

        function showpermission(action, permissionCode, permissionName, permissionIcon) {
            document.getElementById('inputShowPermissionCode').value = permissionCode;
            document.getElementById('inputShowPermissionName').value = permissionName;
            document.getElementById('formShowPermission').action = action;
        }
    </script>
@endsection
