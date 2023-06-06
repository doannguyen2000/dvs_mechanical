@extends('layouts.main-app')

@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body z-index-0 text-start">
                <h5 class="card-title">permissions list</h5>
                <hr>
                <div class="container-fluid">
                    <div class="d-flex justify-content-between">
                        <x-search-filter-component :form-action="route('admin.permissions.list')" :form-method="'GET'" :form-id="'formFilterUsers'">
                            <x-slot name="selectGroupSearch">
                            </x-slot>
                        </x-search-filter-component>
                        <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal"
                            data-bs-target="#createItemInformationModal" type="button"><span><i
                                    class="fa-solid fa-user-plus"></i></span><span
                                class="span-text-new-item ml-3">{{ __('New account') }}</span></button>
                    </div>
                </div>
                <hr>

                @isset($permissions)
                    <x-table-component :array-column-name="['permission_code ', 'permission_name']" :array-column="['permission_code', 'permission_name']" :datas="$permissions" :route-list-name="'admin.permissions.list'" :table="['id' => 'tableShowPermissions', 'checkboxId' => 'inputCheckBoxPermissions']"
                        :route-delete="[
                            'formId' => 'formDeletePermissions',
                            'routeDeleteName' => 'admin.permissions.destroy',
                            'inputId' => 'inputDeletePermissions',
                        ]" :array-functions="['showInforModal']">
                    </x-table-component>
                @endisset
            </div>

        </div>
    </div>
@endsection

@section('modal')
    <x-modal-item-component id="modelItemCreate" :model-id="'createItemInformationModal'" :model-title="'New role'" :array-column="['permission_name']"
        :form="['type' => 'create', 'action' => 'admin.permissions.store', 'method' => 'POST']" />
@endsection
