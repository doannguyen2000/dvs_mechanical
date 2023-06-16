@extends($showModal ? 'layouts.modal-app' : 'layouts.main-app')

@section('content')
    <div class="card {{ $showModal ? '' : 'mt-4' }} bg-body-tertiary">
        <div class="card-body text-start">
            <div class="d-flex justify-content-between">
                <h5 class="card-title">{{ __('Role Show') }}</h5>
                <a role="button" class="icon-link icon-link-hover"
                    @if ($showModal) data-bs-dismiss="modal"
                        aria-label="Close" @else href="{{ route('admin.roles.list') }}" @endif>
                    <i class="fa-regular fa-circle-left"></i>
                    </span>
                    {{ __('Back') }}
                </a>
            </div>
            <hr>
            <div class="mb-1">
                <div class="row g-2">
                    <div class="col-lg-5">
                        <div class="card-body bg-body-secondary border rounded">
                            <h5 class="card-title">{{ __('Role information') }}</h5>
                            <hr>
                            <div>
                                <form
                                    @if (!$showModal) action="{{ route('admin.roles.update', ['id' => $role->id]) }}" method="POST" enctype="multipart/form-data" @endif>
                                    @csrf
                                    <div class="mb-3">
                                        <label for="inputRoleCode" class="form-label">{{ __('Role code') }}</label>
                                        <input type="text" class="form-control bg-primary-subtle border-primary"
                                            id="inputRoleCode" value="{{ $role->role_code }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="inputRoleName" class="form-label">{{ __('Role name') }}</label>
                                        <input type="text"
                                            class="form-control  @if ($showModal) bg-primary-subtle border-primary @endif"
                                            value="{{ $role->role_name }}" id="inputRoleName" name="role_name"
                                            @if ($showModal) disabled @endif>
                                    </div>
                                    <div class="mb-3">
                                        <label for="inputRoleIcon" class="form-label">{{ __('Role icon') }}</label>
                                        <input type="text"
                                            class="form-control  @if ($showModal) bg-primary-subtle border-primary @endif"
                                            value="{{ $role->role_icon }}" id="inputRoleIcon" name="role_icon"
                                            @if ($showModal) disabled @endif>
                                    </div>
                                    <hr>
                                    <div class="mb-3 d-flex justify-content-between">
                                        @if (!$showModal)
                                            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                        @else
                                            <a class="btn btn-primary" href="{{ Request::url() }}"><span><i
                                                        class="fa-solid fa-file-pen"></i></span>
                                                {{ __('Update now') }}</a>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                                aria-label="Close">{{ __('Close') }}</button>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="card-body h-100 bg-body-secondary border rounded">
                            <h5 class="card-title">{{ __('Role permissions') }}</h5>
                            <hr>
                            @if (!$showModal)
                                <x-button-icon :text="'Add role permission'" :option="[
                                    'id' => 'btnShowFormNewItem',
                                    'class' => 'btn btn-sm border mb-1',
                                    'type' => 'button',
                                    'data-bs-toggle' => 'modal',
                                    'data-bs-target' => '#addNewRolePermissions',
                                ]" :icon="'fa-solid fa-plus'" />
                            @endif
                            <div class="overflow-y-auto border">
                                {!! Form::open(['class' => 'form-checkbox', 'id' => 'formlistRolPermissions']) !!}
                                {!! Form::text('item_ids', '', ['class' => 'input-form-role-permission', 'hidden' => 'hidden']) !!}
                                {!! Form::text('item_new_ids', '', ['class' => 'input-form-role-permission-item-new', 'hidden' => 'hidden']) !!}
                                <x-table-item-show-component :option="[
                                    'class' => 'table m-0',
                                    'id' => 'tableShowRole',
                                    'style' => 'min-width: 350px;',
                                ]" :values="$role->permissions" :value-others="[]"
                                    :has-checkbox-item="false" :item-column="[
                                        'tableColumnName' => ['Permission code', 'Permission name'],
                                        'columnImage' => [],
                                        'column' => ['permission_code', 'permission_name'],
                                        'columnWith' => [],
                                        'columnWithIcon' => [],
                                    ]" :modal="[]" :item-functions="!$showModal ? ['delete'] : []"
                                    :form-submit="'formlistRolPermissions'" />
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <x-modal-notification-component :modal-id="'modalNotification'" />
    <x-modal-item-show-component :modal-id="'addNewRolePermissions'" :modal-size="''" :modal-position="''" modal-title="Permissions">
        <x-table-item-show-component :option="[
            'class' => 'table m-0',
            'id' => 'tableShowRole',
            'style' => 'min-width: 365px;',
        ]" :values="$permissions" :value-others="[]" :has-checkbox-item="true"
            :item-column="[
                'tableColumnName' => ['Permission code', 'Permission name'],
                'columnImage' => [],
                'column' => ['permission_code', 'permission_name'],
                'columnWith' => [],
                'columnWithIcon' => [],
            ]" :modal="[]" :item-functions="[]" :form-submit="'formlistRolPermissions'" />
        <div class="my-3 d-flex justify-content-between">
            @if (!$showModal)
                <button type="button" id="btnAddNewRolePermissions" class="btn btn-primary">{{ __('Add') }}</button>
            @else
                <a class="btn btn-primary" href="{{ Request::url() }}"><span><i class="fa-solid fa-file-pen"></i></span>
                    {{ __('Update now') }}</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    aria-label="Close">{{ __('Close') }}</button>
            @endif
        </div>
    </x-modal-item-show-component>
@endsection

@section('style-js')
    <script>
        $(document).ready(function() {
            $('#addNewRolePermissions .checkbox-all').change(function() {
                CheckCheckBoxAll('addNewRolePermissions');
            });

            $('#addNewRolePermissions .checkbox-item').change(function() {
                CheckCheckBoxItem('addNewRolePermissions')
            });

            $('#btnAddNewRolePermissions').click(function() {
                getSelectedCheckboxValues('addNewRolePermissions',
                    'formlistRolPermissions .input-form-role-permission-item-new');
                submitForm('formlistRolPermissions.form-checkbox',
                    '{{ route('admin.roles.updateRolePermission', ['id' => $role->id]) }}',
                    'post');
            });

            $('#buttonYes').click(function() {
                if ($('#modalNotification').data('type') == "modalDeleteRolePermission") {
                    submitForm('formlistRolPermissions.form-checkbox',
                        '{{ route('admin.roles.updateRolePermission', ['id' => $role->id]) }}',
                        'post');
                }
            });
        });

        function deleteItem(itemId) {
            $("#formlistRolPermissions" + " .input-form-role-permission").val(itemId);
            if ($("#formlistRolPermissions" + " .input-form-role-permission").val() !== '') {
                $('#modalNotification').data('type', 'modalDeleteRolePermission');
                if ($('#modalNotification').data('type') == "modalDeleteRolePermission") {
                    $('#modalNotification .modal-footer').show();
                    showModal('modalNotification', 'delete role permissions has id: ' + $("#formlistRolPermissions" +
                        " .input-form-role-permission").val());
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
