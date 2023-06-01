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
                                            aria-describedby="button-addon2" name="search_role"
                                            value="{{ old('search_role') ?? (Request::get('search_role') ?? '') }}">
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
                                                onclick="showRole('{{ route('admin.roles.update', ['id' => $role->id]) }}','{{ $role->role_code }}','{{ $role->role_name }}','{{ $role->role_icon }}')">
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
                                <form id="formRoleDelete" action="{{ route('admin.roles.destroy') }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <input id="inputListRoleDelete" name="role_ids" type="text" hidden>
                                    <button onclick="deleteRoles()" type="button" class="btn btn-sm btn-outline-danger"><i
                                            class="fa-solid fa-trash-can"></i></button>
                                </form>

                            </div>
                        </div>
                        @isset($roles)
                            @php
                                $i = 0;
                                $totalPage = $roles->total();
                            @endphp
                            <div class="col-sm col-xs align-self-end">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-end">
                                        <li class="page-item">
                                            <a class="page-link sm" href="{{ $roles->previousPageUrl() }}">
                                                << </a>
                                        </li>

                                        @foreach ($roles->getUrlRange(1, $totalPage) as $link)
                                            <li class="page-item @if ($roles->currentPage() == ++$i) active @endif"><a
                                                    class="page-link sm" href="{{ $link }}">{{ $i }}</a>
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

                    </div>
                </div>

            </div>

        </div>
    </div>
    <div class="toast" role="alert">
        <div class="toast-header">
            <img src="..." class="rounded me-2" alt="...">
            <strong class="me-auto">Bootstrap</strong>
            <small>11 mins ago</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Hello, world! This is a toast message.
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
        <div class="modal-dialog modal-dialog-centered">
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
                            <input type="text" class="form-control" id="inputShowRoleCode" disabled>
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
                        <button type="submit" class="btn btn-primary">Update role</button>
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
                document.getElementById('inputListRoleDelete').value = values.join(',');
                document.getElementById('formRoleDelete').submit();
            } else {
                alert('null values');
            }
        }

        function showIcon(box, icon) {
            box.innerHTML = icon.value;
        }

        function showRole(action, roleCode, roleName, roleIcon) {
            document.getElementById('inputShowRoleCode').value = roleCode;
            document.getElementById('inputShowRoleName').value = roleName;
            document.getElementById('inputShowRoleIcon').value = roleIcon;
            document.getElementById('formShowRole').action = action;
            showIcon(document.getElementById('boxShowIcon'), document.getElementById('inputShowRoleIcon'));
        }
    </script>
@endsection
