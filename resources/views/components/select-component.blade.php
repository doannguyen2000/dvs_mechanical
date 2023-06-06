@props(['datas', 'selectName', 'dataKeys', 'formId'])
<select onchange="submitForm('{{ $formId }}')" class="form-select-sm border" aria-label=".form-select-sm example"
    @isset($selectName) name="{{ $selectName }}"@endisset style="display: inline-block;">
    @isset($datas)
        <option @if (Request::get($selectName) == '') selected @endif value="">
            {{ __('All') }}
        </option>
        @foreach ($datas as $data)
            <option @if (Request::get($selectName) == $data[$dataKeys[0] ?? 0]) selected @endif value="{{ $data[$dataKeys[0] ?? 0] }}">
                {{ $data[$dataKeys[1] ?? 1] }}
            </option>
        @endforeach
    @endisset
</select>
