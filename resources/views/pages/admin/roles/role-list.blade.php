@extends('layouts.main-app')

@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body text-start">
                <h5 class="card-title">roles list</h5>
                <hr>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-9">
                            <form action="{{ route('admin.roles.list') }}" method="GET">
                                @csrf
                                <div class="row">
                                    <div class="w-auto input-group">
                                        <input type="text" class="border form-control-sm"
                                            placeholder="Recipient's rolename" aria-label="Recipient's rolename"
                                            aria-describedby="button-addon2" name="role_search"
                                            value="{{ old('role_search') ?? (Request::get('role_search') ?? '') }}">
                                        <button class="btn btn-sm border btn-outline-secondary" type="submit"
                                            id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col align-self-end">
                            <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal"
                                data-bs-target="#createNewRoleModal" type="button"><span><i
                                        class="fa-solid fa-plus"></i></i></span>&nbsp;New Role</button>
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
                                        onclick="toggleAllCheckboxes();" id="allRolesChecked">
                                    <label class="form-check-label" for="allRolesChecked">
                                        all
                                    </label>
                                </div>
                            </th>
                            <th scope="col">Role code</th>
                            <th scope="col">Role name</th>
                            <th scope="col">Role icon</th>
                            <th class="text-center" scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="tbdRoleList">
                        @isset($roles)
                            @php
                                $index = 0;
                            @endphp
                            @foreach ($roles as $role)
                                <tr>
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkbox{{ ++$index }}"
                                                value="{{ $role->id }}">
                                        </div>
                                    </th>
                                    <td>{{ $role->role_code }}</td>
                                    <td>{{ $role->role_name }}</td>
                                    <td>{!! $role->role_icon !!}</td>
                                    <td class="text-center">
                                        <span>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#showRoleModal"
                                                class="d-inline-flex focus-ring py-1 px-2 text-decoration-none border rounded-2"
                                                style="--bs-focus-ring-color: rgba(var(--bs-success-rgb), .25)"
                                                onclick="showRole('{{ route('admin.roles.update', ['id' => $role->id]) }}','{{ $role->role_code }}','{{ $role->role_name }}','{{ $role->role_icon }}', {{ json_encode($role->permissions) }})">
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
                                <form hidden id="formRoleFunction" action="{{ route('admin.roles.destroy') }}">
                                    @csrf
                                    <input id="inputRoleFunction" type="text" hidden>
                                </form>
                                <button onclick="deleteRoles()" type="button" style="display: inline-block;"
                                    class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can"></i></button>
                                <select class="form-select-sm form-select m-0" id="selectRolePaginate"
                                    style="width: 75px;display: inline-block" aria-label="Default select example"
                                    onchange="paginateRoles();">
                                    <option @if (Request::get('role_paginate' == null) || Request::get('role_paginate') == '5') selected @endif value="5">5</option>
                                    <option @if (Request::get('role_paginate') == '10') selected @endif value="10">10</option>
                                    <option @if (Request::get('role_paginate') == '20') selected @endif value="20">20</option>
                                    <option @if (Request::get('role_paginate') == '50') selected @endif value="50">50</option>
                                    <option @if (Request::get('role_paginate') == '100') selected @endif value="100">100</option>
                                    <option @if (Request::get('role_paginate') == '0') selected @endif value="0">All</option>
                                </select>
                            </div>

                        </div>
                        @if (Request::get('role_paginate') !== '0')
                            @isset($roles)
                                @php
                                    $i = 0;
                                @endphp
                                <div class="col-sm col-xs align-self-end">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination justify-content-end">
                                            <li class="page-item">
                                                <a class="page-link sm" href="{{ $roles->previousPageUrl() }}">
                                                    << </a>
                                            </li>

                                            @foreach ($roles->getUrlRange(1, $roles->lastPage()) as $link)
                                                <li class="page-item @if ($roles->currentPage() == ++$i) active @endif"><a
                                                        class="page-link sm"
                                                        href="{{ $link }}">{{ $i }}</a>
                                                </li>
                                            @endforeach
                                            <li class="page-item">
                                                <a class="page-link sm" href="{{ $roles->nextPageUrl() }}">>></a>
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
    <div class="modal fade" id="createNewRoleModal" tabindex="-1" aria-labelledby="createNewRoleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content  bg-dark-subtle">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createNewRoleModalLabel">New role</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('admin.roles.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="inputRoleName" class="form-label">Role name</label>
                            <input type="text" class="form-control" id="inputRoleName" name="role_name"
                                placeholder="Enter role name">
                        </div>
                        <div class="mb-3">
                            <label for="inputRoleIcon" class="form-label">Role icon</label>
                            <div class="row">
                                <div class="col-10"><input type="text" class="form-control" id="inputRoleIcon"
                                        name="role_icon" placeholder="Enter role icon"
                                        onchange="showIcon(document.getElementById('boxShowNewIcon'), document.getElementById('inputRoleIcon'));">
                                </div>
                                <div
                                    class="col-2 border border-primary border-5 rounded-4 text-center d-flex align-items-center justify-content-center">
                                    <div id="boxShowNewIcon" class="mx-auto"></div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Create role</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="showRoleModal" tabindex="-1" aria-labelledby="showRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content  bg-dark-subtle">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="showRoleModalLabel">Role information</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formShowRole" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="inputShowRoleCode" class="form-label">Role code</label>
                            <input type="text" class="form-control bg-primary-subtle border border-primary"
                                id="inputShowRoleCode" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="inputShowRoleName" class="form-label">Role name</label>
                            <input type="text" class="form-control" id="inputShowRoleName" name="role_name"
                                placeholder="Enter role name">
                        </div>
                        <div class="mb-3">
                            <label for="inputShowRoleIcon" class="form-label">Role icon</label>
                            <div class="row">
                                <div class="col-10"><input type="text" class="form-control"
                                        onchange=" showIcon(document.getElementById('boxShowIcon'), document.getElementById('inputShowRoleIcon'))"
                                        id="inputShowRoleIcon" name="role_icon" placeholder="Enter role icon"></div>

                                <div
                                    class="col-2 border border-primary border-5 rounded-4 text-center d-flex align-items-center justify-content-center">
                                    <div id="boxShowIcon" class="mx-auto"></div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <input type="text" name="permission_code" id="inputRolePermissions" hidden>
                            <input type="text" name="permission_code_new" id="inputNewRolePermissions" hidden>
                            <div class="row">
                                <div class="col">
                                    <label for="tableShowPermission" class="form-label">{{ __('Permissons') }}</label>
                                </div>
                                <div class="col text-end">
                                    <button id="btnAddPermission"
                                        onclick="addPermission( document.getElementById('tbdNewRolePermission'),{{ json_encode($permissions) }})"
                                        class="btn btn-sm btn-outline-success" type="button"><span> <i
                                                class="fa-solid fa-plus"></i></span>&nbsp;Add
                                        permission</button>
                                </div>
                            </div>
                            <div class="border border-primary rounded bg-white"
                                style="overflow-y: scroll;max-height: 200px;">
                                <table class="table table-success table-hover  mb-0" id="tableShowPermission">
                                    <thead>
                                        <tr>
                                            <th scope="col">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="flexCheckChecked" checked>
                                                    <label class="form-check-label" for="flexCheckChecked">
                                                        {{ __('All') }}
                                                    </label>
                                                </div>
                                            </th>
                                            <th scope="col">{{ __('Permission name') }}</th>
                                            <th scope="col">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <div>
                                        <tbody id="tbdTablePermission">
                                        </tbody>
                                        <tbody id="tbdNewRolePermission">
                                        </tbody>
                                    </div>

                                </table>
                            </div>

                        </div>
                        <button type="button" onclick="btnUpdateRoleClick()" id="btnUpdateRole"
                            class="btn btn-primary">Update role</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('toast')
    @if (session('roleSuccess'))
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="liveToast" class="toast align-items-center border border-success border-3 bg-success" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('roleSuccess') }}
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
    @if ($errors->any() || session('roleFalse'))
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="liveToast" class="toast align-items-center border border-danger border-3 bg-danger" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ $errors->first() ?? session('roleFalse') }}
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
            var allRolesCheckbox = document.getElementById('allRolesChecked');
            var checkboxes = document.querySelectorAll('#tbdRoleList input[type="checkbox"]:not(#allRolesChecked)');

            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = allRolesCheckbox.checked;
            }
        }

        function submitFormAction(form, action, method = 'get') {
            form.action = action;
            form.setAttribute("method", method);
            form.submit();
        }

        function paginateRoles() {
            document.getElementById('inputRoleFunction').value = document.getElementById('selectRolePaginate').value;
            document.getElementById('inputRoleFunction').name = "role_paginate";
            submitFormAction(document.getElementById('formRoleFunction'), "{{ route('admin.roles.list') }}", 'get');
        }

        function deleteRoles() {
            var tbody = document.getElementById('tbdRoleList');
            var checkboxes = tbody.querySelectorAll('input[type="checkbox"]');
            var values = [];
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    values.push(checkboxes[i].value);
                }
            }

            if (values.length != 0) {
                document.getElementById('inputRoleFunction').value = values.join(',');
                document.getElementById('inputRoleFunction').name = "role_ids";
                submitFormAction(document.getElementById('formRoleFunction'), "{{ route('admin.roles.destroy') }}",
                    'post');
            } else {
                alert('null values');
            }
        }

        function showIcon(box, icon) {
            box.innerHTML = icon.value;
        }

        function showRole(action, roleCode, roleName, roleIcon, permissions) {
            document.getElementById('tbdNewRolePermission').innerHTML = "";
            document.getElementById('inputShowRoleCode').value = roleCode;
            document.getElementById('inputShowRoleName').value = roleName;
            document.getElementById('inputShowRoleIcon').value = roleIcon;
            document.getElementById('formShowRole').action = action;
            showIcon(document.getElementById('boxShowIcon'), document.getElementById('inputShowRoleIcon'));
            var tbody = document.getElementById('tbdTablePermission');
            tbody.innerHTML = "";
            permissions.forEach(function(permission) {
                var row = document.createElement('tr');

                var checkboxCell = document.createElement('th');
                checkboxCell.setAttribute('scope', 'row');
                var checkboxDiv = document.createElement('div');
                checkboxDiv.classList.add('form-check');
                var checkbox = document.createElement('input');
                checkbox.setAttribute('type', 'checkbox');
                checkbox.setAttribute('value', '');
                checkbox.classList.add('form-check-input');
                checkbox.setAttribute('id', 'flexCheckChecked');
                checkbox.setAttribute('checked', '');
                checkboxDiv.appendChild(checkbox);
                checkboxCell.appendChild(checkboxDiv);

                var selectCell = document.createElement('td');
                var select = document.createElement('select');
                select.classList.add('form-control', 'bg-primary-subtle', 'border',
                    'border-primary');
                select.setAttribute('aria-label', 'Disabled select example');
                select.setAttribute('disabled', '');
                var option = document.createElement('option');
                option.setAttribute('selected', '');;
                option.setAttribute('value', permission.permission_code);
                option.textContent = permission.permission_name;
                select.appendChild(option);
                selectCell.appendChild(select);

                var deleteCell = document.createElement('td');
                var deleteButton = document.createElement('button');
                deleteButton.setAttribute('type', 'button');
                deleteButton.classList.add('btn', 'btn-sm', 'btn-outline-danger');
                deleteButton.addEventListener('click', function() {
                    deletePermission(this);
                });
                var deleteIcon = document.createElement('i');
                deleteIcon.classList.add('fa-solid', 'fa-trash-can');
                deleteButton.appendChild(deleteIcon);
                deleteCell.appendChild(deleteButton);

                row.appendChild(checkboxCell);
                row.appendChild(selectCell);
                row.appendChild(deleteCell);

                tbody.appendChild(row);
            });
        }

        function addPermission(tbody, permissions) {
            var tr = document.createElement('tr');

            var th = document.createElement('th');
            var td1 = document.createElement('td');
            var td2 = document.createElement('td');

            var div = document.createElement('div');
            div.setAttribute('class', 'form-check');

            var checkbox = document.createElement('input');
            checkbox.setAttribute('class', 'form-check-input');
            checkbox.setAttribute('type', 'checkbox');
            checkbox.setAttribute('value', '');
            checkbox.setAttribute('id', 'flexCheckChecked');
            checkbox.checked = true;

            div.appendChild(checkbox);
            th.appendChild(div);

            var select = document.createElement('select');
            select.setAttribute('class', 'form-select');
            select.setAttribute('aria-label', 'Default select example');

            permissions.forEach(function(permission) {
                var option = document.createElement('option');
                option.setAttribute('value', permission.permission_code);
                option.textContent = permission.permission_name;
                select.appendChild(option);
            });

            td1.appendChild(select);

            var deleteButton = document.createElement('button');
            deleteButton.setAttribute('type', 'button');
            deleteButton.setAttribute('class', 'btn btn-sm btn-outline-danger');
            deleteButton.addEventListener('click', deletePermission);

            var deleteIcon = document.createElement('i');
            deleteIcon.setAttribute('class', 'fa-solid fa-trash-can');

            deleteButton.appendChild(deleteIcon);
            td2.appendChild(deleteButton);

            tr.appendChild(th);
            tr.appendChild(td1);
            tr.appendChild(td2);

            tbody.appendChild(tr);
        }


        function deletePermission() {
            var row = event.target.closest('tr');
            row.remove();
        }

        function btnUpdateRoleClick() {
            getSelectValues(document.querySelectorAll('#tbdTablePermission select'), document.getElementById(
                'inputRolePermissions'));
            getSelectValues(document.querySelectorAll('#tbdNewRolePermission select'), document.getElementById(
                'inputNewRolePermissions'));

            document.getElementById('formShowRole').submit();
        };


        function getSelectValues(selects, input) {
            // Mảng để lưu trữ giá trị các lựa chọn
            var selectValues = [];

            // Lặp qua từng phần tử select và lấy giá trị
            selects.forEach(function(select) {
                var value = select.value;

                // Kiểm tra giá trị đã tồn tại trong mảng selectValues chưa
                if (!selectValues.includes(value)) {
                    // Thêm giá trị vào mảng selectValues nếu chưa tồn tại
                    selectValues.push(value);
                }
            });

            // Gán giá trị selectValues vào trường input
            input.value = selectValues.join(', ');
        }
    </script>
@endsection
