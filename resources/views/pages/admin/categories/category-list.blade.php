@extends('layouts.main-app')

@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body z-index-0 text-start">
                <h5 class="card-title">categories list</h5>
                <hr>
                <div class="container-fluid">
                    <div class="d-flex justify-content-between">
                        <x-search-filter-component :form-action="route('admin.categories.list')" :form-method="'GET'" :form-id="'formFilterUsers'">
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

                @isset($categories)
                    <x-table-component :array-column-name="['category_code ', 'category_name', 'table_name', 'status']" :array-column="['category_code', 'category_name', 'table_name', 'status']" :datas="$categories" :route-list-name="'admin.categories.list'" :table="['id' => 'tableShowRoles', 'checkboxId' => 'inputCheckBoxRoles']"
                        :route-delete="[
                            'formId' => 'formDeleteRoles',
                            'routeDeleteName' => 'admin.categories.destroy',
                            'inputId' => 'inputDeleteRoles',
                        ]" :array-functions="['showInforModal']">
                    </x-table-component>
                @endisset
            </div>

        </div>
    </div>
@endsection

@section('modal')
    <x-modal-item-component id="modelItemCreate" :model-id="'createItemInformationModal'" :model-title="'New role'" :array-column="['category_name']" :form="['type' => 'create', 'action' => 'admin.categories.store', 'method' => 'POST']"
        :array-check-box="['status']" :array-select="[['selectColumnName' => 'table_name', 'selectColumnValues' => $tables]]" :array-textarea="['category_description']" />
@endsection
