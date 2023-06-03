@props(['arrayColumnName', 'arrayColumn', 'datas', 'routeDelete' => ['formId', 'formAction', 'inputId'], 'routeList', 'table' => ['checkboxId', 'id']])

<div class="overflow-y-auto border rounded mb-3" style="height: 36.8vh !important;">
    <table @isset($table) id="{{ $table['id'] }}" @endisset class="table mb-0">
        <thead>
            <tr>
                <th scope="col">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value=""
                            @isset($table) id="{{ $table['checkboxId'] }}" onclick="toggleAllCheckboxes('{{ $table['checkboxId'] }}','{{ $table['id'] }}')" @endisset>
                        <label class="form-check-label" for="inputCheckedAllItem">
                            {{ __('All') }}
                        </label>
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
                        @isset($arrayColumn)
                            @foreach ($arrayColumn as $column)
                                <td>{!! $data->$column !!}</td>
                            @endforeach
                        @endisset
                        <td>
                            @isset($groupItemFunctions)
                                {{ $groupItemFunctions }}
                            @endisset
                        </td>
                    </tr>
                @endforeach
            @endisset
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-between">
    <div>
        @if (!empty($routeDelete))
            <form id="{{ $routeDelete['formId'] }}" action="{{ $routeDelete['formAction'] }}" method="POST"
                style=" display: inline-block;" class="w-auto">
                @csrf
                <input type="text" name="item_ids" id="{{ $routeDelete['inputId'] }}" hidden>
                @isset($table['checkboxId'])
                    <button type="button" class="btn btn-sm btn-outline-danger"
                        onclick="deleteItem('{{ $table['id'] }}', '{{ $table['checkboxId'] }}', '{{ $routeDelete['inputId'] }}', '{{ $routeDelete['formId'] }}');">
                        <span><i class="fa-regular fa-trash-can"></i></span>
                    </button>
                @endisset
            </form>
        @endif
        <div class="btn-group" role="group">

            <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                aria-expanded="false">
                {{ __('Paginate') }}
            </button>
            <ul class="dropdown-menu overflow-y-auto" style="height: 100px">
                @foreach ([5, 10, 20, 50, 100, 200, 500, 0] as $page)
                    <li><a class="dropdown-item"
                            @isset($routeList) href="{{ $routeList }}?paginate={{ $page }}" @endisset>{{ $page == 0 ? __('All') : $page }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    @if (Request::get('paginate') !== '0')
        <div class="btn-group" role="group" aria-label="First group">
            <a type="button" class="btn btn-sm btn-outline-secondary" href="{{ $datas->previousPageUrl() }}">
                << </a>
                    @foreach ($datas->getUrlRange(1, $datas->lastPage()) as $key => $link)
                        <a type="button"
                            class="btn btn-sm btn-outline-secondary @if (Request::get('page') == $key) active @endif"
                            href="{{ $link }}">{{ $key }}</a>
                    @endforeach
                    <a type="button" class="btn btn-sm btn-outline-secondary"
                        href="{{ $datas->nextPageUrl() }}">>></a>
        </div>
    @endif

</div>
