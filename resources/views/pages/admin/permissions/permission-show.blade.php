@extends($showModal ? 'layouts.modal-app' : 'layouts.main-app')

@section('content')
    <div class="card {{ $showModal ? '' : 'mt-4' }} bg-body-tertiary">
        <div class="card-body text-start">
            <div class="d-flex justify-content-between">
                <h5 class="card-title">{{ __('Permission Show') }}</h5>
                <a role="button" class="icon-link icon-link-hover"
                    @if ($showModal) data-bs-dismiss="modal"
                        aria-label="Close" @else href="{{ route('admin.permissions.list') }}" @endif>
                    <i class="fa-regular fa-circle-left"></i>
                    </span>
                    {{ __('Back') }}
                </a>
            </div>
            <hr>
            <div class="mb-3">
                <div class="row g-2">
                    <div class="col-md-5">
                        <div class="card-body border rounded bg-body-secondary">
                            <h5 class="card-title">{{ __('Permission information') }}</h5>
                            <hr>
                            <form class="row g-3"
                                action="{{ route('admin.permissions.update', ['id' => $permission->id]) }}" method="post">
                                @csrf
                                <div class="col-md-12">
                                    <label for="inputPermissionID" class="form-label">{{ __('Permission ID') }}</label>
                                    <input type="text" class="form-control bg-primary-subtle border-primary"
                                        id="inputPermissionID" value="{{ $permission->id ?? '' }}" disabled>
                                </div>
                                <div class="col-md-12">
                                    <label for="inputPermissionCode" class="form-label">{{ __('Permission code') }}</label>
                                    <input type="text" class="form-control bg-primary-subtle border-primary"
                                        id="inputPermissionCode" value="{{ $permission->permission_code ?? '' }}" disabled>
                                </div>
                                <div class="col-md-12">
                                    <label for="inputPermissionName" class="form-label">{{ __('Permission name') }}</label>
                                    <input type="text"
                                        class="form-control @if ($showModal) bg-primary-subtle border-primary @endif"
                                        name="permission_name" id="inputPermissionName"
                                        value="{{ $permission->permission_name ?? '' }}"
                                        @if ($showModal) disabled @endif>
                                </div>
                                <div class="col-md-12 d-flex justify-content-between mb-3">
                                    @if (!$showModal)
                                        <x-button-icon :text="'Save'" :option="[
                                            'class' => 'btn border btn-outline-primary',
                                            'id' => 'btnUpdatePermission',
                                        ]" :icon="'fa-regular fa-floppy-disk'" />
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
                    <div class="col-md-7">
                        <div class="card-body  border rounded h-100 bg-body-secondary">
                            <h5 class="card-title">{{ __('Roles') }}</h5>
                            <hr>
                            <div class="overflow-y-auto border rounded mb-3" style="height: 35.5vh !important;">
                                <x-table-item-show-component :option="[
                                    'class' => 'table m-0',
                                    'id' => 'tableShowRole',
                                ]" :values="$permission->roles ?? []" :value-others="[]"
                                    :has-checkbox-item="false" :item-column="[
                                        'tableColumnName' => ['Role code', 'Role name'],
                                        'columnImage' => [],
                                        'column' => ['role_code', 'role_name'],
                                        'columnWith' => [],
                                        'columnWithIcon' => [],
                                    ]" :modal="[]" :item-functions="[]"
                                    :form-submit="'formListItem'" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
