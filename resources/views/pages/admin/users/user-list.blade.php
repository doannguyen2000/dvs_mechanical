@extends('layouts.main-app')

@section('content')
    <div class="container">
        <div class="card mt-4 bg-body-tertiary">
            <div class="card-body z-index-0 text-start">
                <h5 class="card-title">Users list</h5>
                <hr>
                {!! Form::open(['class' => 'form-checkbox', 'id' => 'formListItem']) !!}
                {!! Form::text('item_ids', '', ['class' => 'input-form-checkbox', 'hidden' => 'hidden']) !!}
                {!! Form::hidden('role_code', '', ['class' => 'input-form-update-role-code']) !!}
                {!! Form::hidden('page', Request::get('page'), ['class' => 'input-page-form-checkbox']) !!}

                <div class="d-flex justify-content-between">
                    <div>
                        {!! Form::text('search', Request::get('search'), [
                            'class' => 'form-control form-control-sm input-search',
                            'style' => 'width: 190px; display: inline-block;',
                            'placeholder' => 'Search ...',
                        ]) !!}

                        {!! Form::select(
                            'select_filter_role',
                            array_merge(['' => 'All'], $roles->pluck('role_name', 'role_code')->toArray()),
                            Request::get('select_filter_role'),
                            [
                                'class' => 'form-select form-select-sm w-auto select-search',
                                'style' => 'display: inline-block;',
                            ],
                        ) !!}

                        {!! Form::select(
                            'select_filter_is_online',
                            array_merge(['' => 'All'], ['on' => 'Online', 'off' => 'Offline']),
                            Request::get('select_filter_is_online'),
                            [
                                'class' => 'form-select form-select-sm w-auto select-search',
                                'style' => 'display: inline-block;',
                            ],
                        ) !!}
                        <x-button-icon :option="[
                            'id' => 'btnSearch',
                            'class' => 'btn btn-sm border',
                            'style' => 'display: inline-block;',
                            'type' => 'button',
                        ]" :icon="'fa-solid fa-magnifying-glass'" />
                    </div>
                    <x-button-icon :text="'New'" :option="[
                        'id' => 'btnShowFormNewItem',
                        'class' => 'btn btn-sm border',
                        'type' => 'button',
                        'data-bs-toggle' => 'modal',
                        'data-bs-target' => '#addItemInformationModal',
                    ]" :icon="'fa-solid fa-plus'" />
                </div>
                <hr>
                <div class="overflow-y-auto border rounded mb-3 bg-body-secondary" style="height: 35.5vh !important;">
                    <x-table-item-show-component :option="[
                        'class' => 'table m-0',
                        'id' => 'tableShowRole',
                        'style' => 'min-width: 600px;',
                    ]" :values="$users" :value-others="['roles' => $roles]" :has-checkbox-item="true"
                        :item-column="[
                            'tableColumnName' => ['Avatar', 'Username', 'status', 'Role'],
                            'columnImage' => ['avatar'],
                            'column' => ['name', 'is_online'],
                            'columnWith' => [],
                            'columnWithIcon' => ['role' => ['role_icon', 'role_name']],
                        ]" :modal="[
                            'showItem' => [
                                'id' => 'showItemInformationModal',
                                'route' => 'admin.users.show',
                            ],
                        ]" :item-functions="['delete', 'show', 'updateRole']" :form-submit="'formListItem'" />
                </div>

                <div class="d-flex justify-content-between">
                    <div>
                        <x-button-icon :option="[
                            'id' => 'btnDeleteItem',
                            'class' => 'btn btn-sm border',
                            'style' => 'display: inline-block;',
                            'type' => 'button',
                        ]" :icon="'fa-regular fa-trash-can'" />
                        <div class="btn btn-sm p-0" style="display: inline-block;">
                            {!! Form::select(
                                'paginate',
                                [
                                    5 => 5,
                                    10 => 10,
                                    50 => 50,
                                    0 => 'all',
                                ],
                                Request::get('paginate') ?? 5,
                                [
                                    'class' => 'form-select form-select-sm',
                                    'id' => 'selectPaginate',
                                ],
                            ) !!}
                        </div>
                    </div>
                    @if (!in_array(Request::get('paginate'), ['0']))
                        <div class="btn-group" role="group" aria-label="First group">
                            <a type="button" class="btn btn-sm btn-outline-secondary"
                                href="{{ $users->previousPageUrl() }}">
                                &laquo; </a>
                            @foreach ($users->getUrlRange(1, $users->lastPage()) as $key => $link)
                                <a type="button"
                                    onclick="submitForm('formListItem.form-checkbox',
                                '{{ Request::fullUrl() }}',
                                'get','formListItem .input-page-form-checkbox','{{ $key }}');"
                                    class="btn btn-sm btn-outline-secondary @if (Request::get('page') == $key || (empty(Request::get('page')) && $key === 1)) active @endif"
                                    href="#">{{ $key }}</a>
                            @endforeach
                            <a type="button" class="btn btn-sm btn-outline-secondary"
                                href="{{ $users->nextPageUrl() }}">&raquo;</a>
                        </div>
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <x-modal-notification-component :modal-id="'modalNotification'" />
    <x-modal-item-show-component :modal-id="'showItemInformationModal'" :modal-size="'modal-xl'" />
    <x-modal-item-new-component :modal-title="'Create new user'" :modal-id="'addItemInformationModal'" :modal-size="''" :array-input="[
        'Username' => 'name',
        'Email Address' => 'email',
        'Password' => 'password',
        'Password confirmation' => 'password_confirmation',
    ]"
        :array-textareat="[]" :array-select="[]" :array-checkbox="[]" :route="['name' => 'admin.users.store', 'method' => 'post']" />
@endsection

@section('style-js')
    <script>
        $(document).ready(function() {
            $('#formListItem .checkbox-all').change(function() {
                CheckCheckBoxAll('formListItem');
            });

            $('#formListItem .checkbox-item').change(function() {
                CheckCheckBoxItem('formListItem');
            });

            $('#formListItem .select-search').change(function() {
                submitForm('formListItem.form-checkbox', '{{ Request::fullUrl() }}', 'get');
            });

            $('#btnSearch').click(function() {
                submitForm('formListItem.form-checkbox', '{{ Request::fullUrl() }}', 'get');
            });

            $('#selectPaginate').change(function() {
                submitForm('formListItem.form-checkbox', '{{ Request::fullUrl() }}', 'get');
            });

            $('#btnDeleteItem').click(function() {
                getSelectedCheckboxValues('formListItem', 'formListItem .input-form-checkbox');
                if ($("#formListItem" + " .input-form-checkbox").val() !== '') {
                    $('#modalNotification').data('type', 'modalDeleteRole');
                    if ($('#modalNotification').data('type') == "modalDeleteRole") {
                        $('#modalNotification .modal-footer').show();
                        showModal('modalNotification', 'delete role has id: ' + $("#formListItem" +
                            " .input-form-checkbox").val());
                    }
                } else {
                    $('#modalNotification').data('type', 'modalError');
                    $('#modalNotification .modal-footer').hide();
                    showModal('modalNotification', 'No records selected!');
                    setTimeout(function() {
                        $('#modalNotification').modal('hide');
                    }, 1000);
                }
            });

            $('#buttonYes').click(function() {
                if ($('#modalNotification').data('type') == "modalDeleteRole") {
                    submitForm('formListItem.form-checkbox',
                        '{{ route('admin.users.destroy') }}',
                        'post');
                }
            });
        });

        function deleteItem(itemId) {
            $("#formListItem" + " .input-form-checkbox").val(itemId);
            if ($("#formListItem" + " .input-form-checkbox").val() !== '') {
                $('#modalNotification').data('type', 'modalDeleteRole');
                if ($('#modalNotification').data('type') == "modalDeleteRole") {
                    $('#modalNotification .modal-footer').show();
                    showModal('modalNotification', 'delete role has id: ' + $("#formListItem" +
                        " .input-form-checkbox").val());
                }
            } else {
                $('#modalNotification').data('type', 'modalError');
                $('#modalNotification .modal-footer').hide();
                showModal('modalNotification', 'No records selected!');
                setTimeout(function() {
                    $('#modalNotification').modal('hide');
                }, 1000);
            }
        }
    </script>
@endsection
