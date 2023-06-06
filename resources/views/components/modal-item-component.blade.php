@props(['modelId', 'modelTitle', 'modalSize', 'dataValue', 'arrayColumn', 'form', 'arrayWith', 'arrayCheckBox', 'arraySelect', 'arrayTextarea', 'arrayInputIcon'])

<div class="modal fade" id="@isset($modelId){{ $modelId }}@endisset" tabindex="-1"
    aria-labelledby="showItemInformationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered @isset($modalSize){{ $modalSize }}@endisset">
        <div class="modal-content bg-dark-subtle">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="showItemInformationModalLabel">
                    @isset($modelTitle)
                        {{ $modelTitle }}
                    @endisset
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if (isset($form) && isset($form['type']))
                    <form
                        action="@if (isset($form['action'])) @if ($form['type'] === 'create'){{ route($form['action']) }}@else{{ route($form['action'], ['id' => $dataValues->id ?? '']) }} @endif @endif"
                        method="@isset($form['method']){{ $form['method'] }}@endisset">
                        @csrf
                        @isset($arrayColumn)
                            @foreach ($arrayColumn as $column)
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1"
                                        class="form-label">{{ str_replace('_', ' ', $column) }}</label>
                                    <input type="text" class="form-control bg-primary-subtle border border-primary"
                                        name="{{ $column }}"
                                        value="@isset($dataValue){{ $dataValue->{$column} }}@endisset"
                                        @if (in_array($form['type'], ['show', 'show2'])) disabled @endif
                                        placeholder="Enter {{ $column }}">
                                </div>
                            @endforeach
                        @endisset
                        @isset($arrayInputIcon)
                            @foreach ($arrayInputIcon as $key => $column)
                                <div class="mb-3 row">
                                    <label for="exampleFormControlInput1"
                                        class="form-label">{{ str_replace('_', ' ', $column) }}</label>
                                    <div class="col-sm-10 icon">
                                        <input type="text"
                                            class="form-control bg-primary-subtle border border-primary input-icon{{ $key }}"
                                            name="{{ $column }}"
                                            value="@isset($dataValue){{ $dataValue->{$column} }}@endisset"
                                            @if (in_array($form['type'], ['show', 'show2'])) disabled @endif
                                            placeholder="Enter {{ $column }}"
                                            onchange="changeHTML($('#{{ $modelId }} .box-icon{{ $key }}'), $('#{{ $modelId }} .input-icon{{ $key }}'))">
                                    </div>
                                    <div class="col-sm-2 box-icon{{ $key }} border border-3 rounded text-center border-primary" style="font-size: 1.3rem;">

                                    </div>
                                </div>
                            @endforeach
                        @endisset
                        @isset($arraySelect)
                            @foreach ($arraySelect as $column)
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1"
                                        class="form-label">{{ str_replace('_', ' ', $column['selectColumnName']) }}</label>
                                    <select class="form-select" aria-label="Default select example"
                                        name="{{ $column['selectColumnName'] }}">
                                        @foreach ($column['selectColumnValues'] as $item)
                                            <option value="{{ $item }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach
                        @endisset
                        @isset($arrayWith)
                            @foreach ($arrayWith as $with)
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1"
                                        class="form-label">{{ $with['withName'] }}</label>
                                    <input type="text" class="form-control bg-primary-subtle border border-primary"
                                        value="@isset($dataValue){{ $dataValue->{$with['withName']} }}@endisset"
                                        @if (in_array($form['type'], ['show', 'show2'])) disabled @endif>
                                </div>
                            @endforeach
                        @endisset
                        @isset($arrayCheckBox)
                            @foreach ($arrayCheckBox as $column)
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1"
                                        class="form-label">{{ str_replace('_', ' ', $column) }}</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            name="{{ $column }}" checked>
                                        <label class="form-check-label"
                                            for="flexSwitchCheckChecked">{{ __('On') }}</label>
                                    </div>
                                </div>
                            @endforeach
                        @endisset
                        @isset($arrayTextarea)
                            @foreach ($arrayTextarea as $column)
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1"
                                        class="form-label">{{ str_replace('_', ' ', $column) }}</label>
                                    <textarea class="form-control" name="{{ $column }}" rows="3"
                                        @if (in_array($form['type'], ['show', 'show2'])) disabled @endif placeholder="Enter {{ $column }}">@isset($dataValue){{ $dataValue->{$column} }}@endisset</textarea>
                                </div>
                            @endforeach
                        @endisset
                        @if (isset($form['type']) && !in_array($form['type'], ['show', 'show2']))
                            <button
                                type="@if (!in_array($form['type'], ['show', 'show2'])) {{ __('submit') }}@else{{ __('button') }} @endif"
                                class="btn btn-primary">
                                {{ $form['type'] === 'create' ? __('Create') : ($form['type'] === 'Update' ? __('Update') : __('Button')) }}
                            </button>
                        @endif
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
