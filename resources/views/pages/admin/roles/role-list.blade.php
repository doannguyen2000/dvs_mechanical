@extends('layouts.main-app')

@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body z-index-0 text-start">
                <h5 class="card-title">Roles list</h5>
                <hr>
                <div class="container-fluid">
                    <div class="d-flex justify-content-between">
                        <x-search-filter-component :form-action="route('admin.roles.list')" :form-method="'GET'" :form-id="'formFilterUsers'">
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

                @isset($roles)
                    <x-table-component :array-column-name="['role_code ', 'role_name', 'role_icon']" :array-column="['role_code', 'role_name', 'role_icon']" :datas="$roles" :route-list-name="'admin.roles.list'" :table="['id' => 'tableShowRoles', 'checkboxId' => 'inputCheckBoxRoles']"
                        :route-delete="[
                            'formId' => 'formDeleteRoles',
                            'routeDeleteName' => 'admin.roles.destroy',
                            'inputId' => 'inputDeleteRoles',
                        ]" :array-functions="['showInforModal']">
                    </x-table-component>
                @endisset
            </div>

        </div>
    </div>
@endsection

@section('modal')
    <x-modal-item-component id="modelItemCreate" :model-id="'createItemInformationModal'" :model-title="'New role'" :array-column="['role_name']" :array-input-icon="['role_icon']"
        :form="['type' => 'create', 'action' => 'admin.roles.store', 'method' => 'POST']" />
@endsection
