@props([
    'option' => [],
    'values' => null,
    'valueOthers' => [],
    'hasCheckboxItem' => false,
    'rowIdex' => 0,
    'itemColumn' => [
        'tableColumnName' => [],
        'columnImage' => [],
        'column' => [],
        'columnWith' => [],
        'columnWithIcon' => [],
    ],
    'route' => [
        'list' => null,
        'show' => null,
        'update' => null,
        'destroy' => null,
    ],
    'modal' => [
        'showItem' => [
            'id' => null,
            'route' => null,
        ],
    ],
    'itemFunctions' => [], //'delete', 'show', 'updateRole'
    'formSubmit' => null,
])

<div>
    <table {{ $attributes->merge($option) }} style="min-width: 600px">
        <thead>
            <tr>
                <th class="text-center" scope="col">
                    @if ($hasCheckboxItem)
                        {!! Form::checkbox('', true, false, ['class' => 'checkbox-all']) !!}
                    @else
                        {{ __('index') }}
                    @endif
                </th>
                @foreach ($itemColumn['tableColumnName'] as $column)
                    <th class="text-start" scope="col">{{ $column }}</th>
                @endforeach
                <th class="text-center" scope="col">{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($values as $item)
                <tr>
                    <th class="text-center" scope="row">
                        @if ($hasCheckboxItem)
                            {!! Form::checkbox('', $item->id, false, ['class' => 'checkbox-item']) !!}
                        @else
                            {{ ++$rowIdex }}
                        @endif
                    </th>
                    @foreach ($itemColumn['columnImage'] as $column)
                        <td>
                            <img src="@if (!empty($item->{$column})) {{ asset(Storage::url('users/' . $item->{$column})) }}@else{{ asset('assets/images/adminAvatar.jpg') }} @endif"
                                class="img-fluid rounded border" style="width: 25px;height: 25px;" alt="...">
                        </td>
                    @endforeach
                    @foreach ($itemColumn['column'] as $column)
                        <td scope="col">{!! $item->{$column} !!}</td>
                    @endforeach
                    @foreach ($itemColumn['columnWithIcon'] as $key => $column)
                        <td scope="col">{!! $item->{$key}->{reset($column)} ?? '' !!}&nbsp;{!! $item->{$key}->{end($column)} ?? '' !!}</td>
                    @endforeach
                    <td class="text-center">
                        @if (in_array('updateRole', $itemFunctions))
                            <div class="dropdown show" style="display: inline-block;">
                                <button class="d-inline-flex focus-ring py-1 px-2 text-decoration-none border rounded-2"
                                    style="--bs-focus-ring-color: rgba(var(--bs-success-rgb), .25)" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="true">
                                    <i class="fa-solid fa-user-shield"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    @isset($valueOthers)
                                        @if (!empty($valueOthers['roles']))
                                            <li><a class="dropdown-item"
                                                    @if (!is_null($item->role_code)) onclick="submitForm('{{ $formSubmit }}','{{ route('admin.users.updateRoleUser', ['id' => $item->id]) }}','POST', '{{ $formSubmit }} .input-form-update-role-code', '')" @endif>{{ __('Delete Roll') }}</a>
                                            </li>
                                            @foreach ($valueOthers['roles'] as $role)
                                                <li><a class="dropdown-item"
                                                        onclick="submitForm('{{ $formSubmit }}','{{ route('admin.users.updateRoleUser', ['id' => $item->id]) }}','POST', '{{ $formSubmit }} .input-form-update-role-code', '{{ $role->role_code }}')">{!! $role->role_icon !!}&nbsp;{{ $role->role_name }}</a>
                                                </li>
                                            @endforeach
                                        @endif
                                    @endisset
                                </ul>
                            </div>
                        @endif
                        @if (in_array('show', $itemFunctions))
                            <span class="d-inline-flex focus-ring py-1 px-2 text-decoration-none border rounded-2">
                                <a class="icon-link icon-link-hove" data-bs-toggle="modal"
                                    data-bs-target="#{{ $modal['showItem']['id'] }}"
                                    onclick="showItemModel('{{ $modal['showItem']['id'] . ' .modal-body' }}','{{ route($modal['showItem']['route'], ['id' => $item->id]) }}');"
                                    style="--bs-icon-link-transform: translate3d(0, -.125rem, 0);" href="#">
                                    <i class="bi fa-solid fa-eye"></i>
                                </a>
                            </span>
                        @endif
                        @if (in_array('delete', $itemFunctions))
                            <span class="d-inline-flex focus-ring py-1 px-2 text-decoration-none border rounded-2">
                                <a class="icon-link icon-link-hover" onclick="deleteItem('{{ $item->id }}')"
                                    style="--bs-icon-link-transform: translate3d(0, -.125rem, 0);" href="#">
                                    <i class="bi fa-regular fa-trash-can text-danger"></i>
                                </a>
                            </span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
