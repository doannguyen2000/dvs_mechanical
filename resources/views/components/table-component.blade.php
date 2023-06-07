@props(['arrayColumnName', 'arrayColumn', 'datas', 'dataOthers', 'routeDelete' => ['formId', 'routeDeleteName', 'inputId'], 'routeListName', 'table' => ['checkboxId', 'id'], 'arrayFunctions', 'routeShowName', 'arrayColumnImg', 'routeUpdateStatus'])

<div class="overflow-y-auto border rounded mb-3" style="height: 36.8vh !important;">
    <table @isset($table) id="{{ $table['id'] }}" @endisset class="table mb-0"
        style="min-width: 637px">
        <thead>
            <tr>
                <th scope="col">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value=""
                            @isset($table) id="{{ $table['checkboxId'] }}" onclick="toggleAllCheckboxes('{{ $table['checkboxId'] }}','{{ $table['id'] }}')" @endisset>
                    </div>
                </th>
                @isset($arrayColumnName)
                    @foreach ($arrayColumnName as $columnName)
                        <th scope="col">{{ $columnName }}</th>
                    @endforeach
                @endisset
                <th scope="col">{{ __('Action') }}</th>
            </tr>
        </thead>

        <tbody>
            @isset($datas)
                @foreach ($datas as $data)
                    <tr>
                        <th scope="row">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $data->id }}"
                                    id="inputCheckItem">
                            </div>
                        </th>
                        @isset($arrayColumnImg)
                            @foreach ($arrayColumnImg as $column)
                                <td>
                                    <img src="@if (!empty($data->$column)) {{ asset(Storage::url('users/' . $data->$column)) }}@else{{ asset('assets/images/adminAvatar.jpg') }} @endif"
                                        class="img-fluid rounded border" style="width: 25px;height: 25px;" alt="...">
                                </td>
                            @endforeach
                        @endisset
                        @isset($arrayColumn)
                            @foreach ($arrayColumn as $column)
                                <td>{!! $data->$column ?? '' !!}</td>
                            @endforeach
                        @endisset
                        @isset($arrayWith)
                            @foreach ($arrayWith as $with)
                                <td>
                                    @foreach ($with['withColumn'] as $column)
                                        {!! $data->{$with['withName']}->{$column} ?? null !!}
                                    @endforeach
                                </td>
                            @endforeach
                        @endisset
                        <td>
                            @isset($arrayFunctions)
                                @if (in_array('updateRole', $arrayFunctions))
                                    <span style="display: inline-block;">
                                        <div role="group">
                                            <button
                                                class="d-inline-flex focus-ring py-1 px-2 text-decoration-none border rounded-2"
                                                style="--bs-focus-ring-color: rgba(var(--bs-success-rgb), .25)" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-user-shield"></i>
                                            </button>
                                            @isset($dataOthers)
                                                @if (!empty($dataOthers['roles']))
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item"
                                                                @if (!is_null($data->role_code)) onclick="submitForm('formUpdateRoleUser','{{ route('admin.users.updateRoleUser', ['id' => $data->id]) }}','POST', 'inputRoleCodeUpdateRoleUser', '')" @endif>{{ __('Delete Roll') }}</a>
                                                        </li>
                                                        @foreach ($dataOthers['roles'] as $role)
                                                            <li><a class="dropdown-item"
                                                                    onclick="submitForm('formUpdateRoleUser','{{ route('admin.users.updateRoleUser', ['id' => $data->id]) }}','POST', 'inputRoleCodeUpdateRoleUser', '{{ $role->role_code }}')">{!! $role->role_icon !!}&nbsp;{{ $role->role_name }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            @endisset
                                        </div>
                                    </span>
                                @endif
                                @if (in_array('showInforModal', $arrayFunctions))
                                    <span style="display: inline-block;">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#showItemInformationModal"
                                            class="d-inline-flex focus-ring py-1 px-2 text-decoration-none border rounded-2"
                                            onclick="showItemModel('boxShowItemContent','{{ route('admin.users.show', ['id' => $data->id]) }}');appear()"
                                            style="--bs-focus-ring-color: rgba(var(--bs-success-rgb), .25)">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </span>
                                @endif

                                @if (in_array('showInforNewPage', $arrayFunctions))
                                    <span style="display: inline-block;">
                                        <div role="group">
                                            <a href="{{ route($routeShowName, ['id' => $data->id]) }}"
                                                class="d-inline-flex focus-ring py-1 px-2 text-decoration-none border rounded-2"
                                                style="--bs-focus-ring-color: rgba(var(--bs-success-rgb), .25)">
                                                <i class="fa-solid fa-chalkboard-user"></i>
                                            </a>
                                        </div>
                                    </span>
                                @endif
                                @if (in_array('delete', $arrayFunctions))
                                    <span style="display: inline-block;">
                                        <a @if (!empty($routeDelete)) onclick="submitFormSetInputValues('{{ $routeDelete['formId'] }}','{{ $routeDelete['inputId'] }}','{{ $data->id }}');" @endif
                                            href="#"
                                            class="d-inline-flex focus-ring py-1 px-2 text-decoration-none border rounded-2"
                                            style="--bs-focus-ring-color: rgba(var(--bs-success-rgb), .25)">
                                            <i class="fa-solid fa-user-large-slash" style="color: #e43307;"></i>
                                        </a>
                                    </span>
                                @endif
                            @endisset
                        </td>
                    </tr>
                @endforeach
            @endisset
        </tbody>
    </table>
    <form id="formUpdateRoleUser" hidden>
        @csrf
        <input type="text" id="inputRoleCodeUpdateRoleUser" name="role_code">
    </form>
</div>
<div class="d-flex justify-content-between">
    <div>
        @if (!empty($routeDelete))
            <form id="{{ $routeDelete['formId'] }}" action="{{ route($routeDelete['routeDeleteName']) }}"
                method="POST" style=" display: inline-block;" class="w-auto">
                @csrf
                <input type="text" name="item_ids" id="{{ $routeDelete['inputId'] }}" hidden>
                @isset($table['checkboxId'])
                    <button type="button" class="btn btn-sm btn-outline-danger"
                        onclick="sentItemChecked('{{ $table['id'] }}', '{{ $table['checkboxId'] }}', '{{ $routeDelete['inputId'] }}', '{{ $routeDelete['formId'] }}');">
                        <span><i class="fa-regular fa-trash-can"></i></span>
                    </button>
                @endisset
            </form>
        @endif
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown"
                aria-expanded="false">
                {{ __('Paginate') }}
            </button>
            <ul class="dropdown-menu overflow-y-auto" style="height: 100px">
                @foreach ([5, 10, 20, 50, 100, 200, 500, 0] as $page)
                    <li><a class="dropdown-item"
                            @isset($routeListName) href="{{ route($routeListName) }}?paginate={{ $page }}" @endisset>{{ $page == 0 ? __('All') : $page }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
        @if (!empty($routeUpdateStatus))
            <form id="{{ $routeUpdateStatus['formId'] }}" action="{{ route($routeUpdateStatus['routeDeleteName']) }}"
                method="POST" style=" display: inline-block;" class="w-auto btn-group" role="group">
                @csrf
                <input type="text" name="item_ids" id="{{ $routeUpdateStatus['inputIdsId'] }}" hidden>
                <input type="text" name="status" id="{{ $routeUpdateStatus['inputStatusId'] }}" hidden>
                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle rounded"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    {{ __('status') }}
                </button>
                <ul class="dropdown-menu overflow-y-auto" style="min-height: 50px;">
                    @foreach ($routeUpdateStatus['arrayData'] as $text => $value)
                        <li>
                            <button type="button"
                                onclick="updateInputValue('{{ $routeUpdateStatus['inputStatusId'] }}','{{ $value }}');sentItemChecked('{{ $table['id'] }}', '{{ $table['checkboxId'] }}', '{{ $routeUpdateStatus['inputIdsId'] }}', '{{ $routeUpdateStatus['formId'] }}');"
                                class="dropdown-item">{{ $text }}</button>
                        </li>
                    @endforeach
                </ul>
            </form>
        @endif
    </div>
    @if (Request::get('paginate') !== '0')
        <div class="btn-group" role="group" aria-label="First group">
            <a type="button" class="btn btn-sm btn-outline-secondary" href="{{ $datas->previousPageUrl() }}">
                &laquo; </a>
            @foreach ($datas->getUrlRange(1, $datas->lastPage()) as $key => $link)
                <a type="button"
                    class="btn btn-sm btn-outline-secondary @if (Request::get('page') == $key || (empty(Request::get('page')) && $key === 1)) active @endif"
                    href="{{ $link }}">{{ $key }}</a>
            @endforeach
            <a type="button" class="btn btn-sm btn-outline-secondary"
                href="{{ $datas->nextPageUrl() }}">&raquo;</a>
        </div>
    @endif
</div>
