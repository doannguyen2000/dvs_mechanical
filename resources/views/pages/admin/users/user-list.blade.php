@extends('layouts.main-app')

@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body z-index-0 text-start">
                <h5 class="card-title">Users list</h5>
                <hr>
                <div class="container-fluid">
                    <div class="d-flex justify-content-between">
                        <x-search-filter-component :form-action="route('admin.users.list')" :form-method="'GET'" :form-id="'formFilterUsers'">
                            <x-slot name="selectGroupSearch">
                                <x-select-component :select-name="'select_filter_role'" :datas="$roles" :data-keys="['role_code', 'role_name']"
                                    :form-id="'formFilterUsers'" />
                                <x-select-component :select-name="'select_filter_is_online'" :datas="[['on', 'Online'], ['off', 'Offline']]" :form-id="'formFilterUsers'" />
                            </x-slot>
                        </x-search-filter-component>
                        <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal"
                            data-bs-target="#createItemInformationModal" type="button"><span><i
                                    class="fa-solid fa-user-plus"></i></span><span
                                class="span-text-new-item ml-3">{{ __('New account') }}</span></button>
                    </div>
                </div>
                <hr>

                @isset($users)
                    <x-table-component :array-column-img="['avatar']" :array-column-name="['Avatar', 'Name', 'Status', 'role']" :array-column="['name', 'is_online']" :datas="$users"
                        :route-list-name="'admin.users.list'" :table="['id' => 'tableShowUsers', 'checkboxId' => 'inputCheckBoxUsers']" :route-delete="[
                            'formId' => 'formDeleteUsers',
                            'routeDeleteName' => 'admin.users.destroy',
                            'inputId' => 'inputDeleteUsers',
                        ]" :route-update-status="[
                            'formId' => 'formUpdateStatusUsers',
                            'routeDeleteName' => 'admin.users.updateStatusUser',
                            'inputIdsId' => 'inputIdsUpdateUsers',
                            'inputStatusId' => 'inputStatusUpdateUsers',
                            'arrayData' => [
                                'Online' => 1,
                                'Offline' => 0,
                            ],
                        ]" :array-with="[['withName' => 'role', 'withColumn' => ['role_icon', 'role_name']]]"
                        :array-functions="['showInforModal', 'delete', 'updateRole']" :route-show-name="'admin.users.show'" :data-others="['roles' => $roles]">
                    </x-table-component>
                @endisset
            </div>

        </div>
    </div>
@endsection

@section('modal')
    <x-modal-item-component id="modelItemCreate" :model-id="'createItemInformationModal'" :model-title="'New user'" :array-column="['name', 'email', 'password', 'password_confirmation']"
        :form="['type' => 'create', 'action' => 'admin.users.store', 'method' => 'POST']" />
    <div class="modal fade" id="showItemInformationModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body hidden" id="boxShowItemContent">
                </div>
            </div>
        </div>
    </div>
@endsection
