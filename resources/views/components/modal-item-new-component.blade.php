@props(['modalTitle' => 'Modal Title', 'modalId' => null, 'modalSize' => null, 'arrayInput' => [], 'arrayTextareat' => [], 'arraySelect' => [], 'arrayCheckbox' => [], 'route' => ['name' => null, 'method' => 'get']])

<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label"
    aria-hidden="true">
    <div class="modal-dialog {{ $modalSize }} modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route($route['name']) }}" method="{{ $route['method'] }}">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $modalTitle }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @foreach ($arrayInput as $key => $name)
                        <div class="mb-3">
                            <label for="input{{ $name }}" class="form-label">{{ $key }}</label>
                            <input type="text" name="{{ $name }}" class="form-control"
                                id="input{{ $name }}" placeholder="Enter {{ $key }} here">
                        </div>
                    @endforeach
                    @foreach ($arraySelect as $key => $values)
                        <div class="mb-3">
                            <label for="select{{ $values['name'] }}" class="form-label">{{ $key }}</label>
                            <select class="form-select" name="{{ $values['name'] }}" id="select{{ $values['name'] }}">
                                @foreach ($values['data'] as $text => $value)
                                    <option value="{{ $value }}">{{ $text }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                    @foreach ($arrayCheckbox as $key => $name)
                        <div class="mb-3">
                            <label for="checkbox{{ $name }}" class="form-label">{{ $key }}</label>
                            <div class="form-check form-switch" id="checkbox{{ $name }}">
                                <input class="form-check-input" name="{{ $name }}" type="checkbox"
                                    role="switch" id="inputCheckbox{{ $name }}" checked>
                                <label class="form-check-label"
                                    for="inputCheckbox{{ $name }}">{{ __('Active') }}</label>
                            </div>
                        </div>
                    @endforeach
                    @foreach ($arrayTextareat as $key => $name)
                        <div class="mb-3">
                            <label for="textarea{{ $name }}" class="form-label">{{ $key }}</label>
                            <textarea class="form-control" name="{{ $name }}" id="textarea{{ $name }}" rows="3"></textarea>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
