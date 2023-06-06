@props(['formAction', 'formMethod', 'formId'])
<div>
    <form id="@isset($formId){{ $formId }}@endisset"
        action="@isset($formAction){{ $formAction }}@endisset"
        method="@isset($formMethod){{ $formMethod }}@endisset">
        @csrf
        <div class="row">
            <div class="col p-0">
                <div class="w-auto input-group" style="min-width: 185px;">
                    <input type="text" name="search" class="border form-control-sm" style="width: 70%;"
                        placeholder="Search here ..." aria-describedby="button-addon2"
                        value="{{ old('search') ?? (Request::get('search') ?? '') }}">
                    <button class="btn btn-sm border btn-outline-secondary" style="width: 30%" type="submit"
                        id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </div>
            <div class="col p-0">
                @isset($selectGroupSearch)
                    {{ $selectGroupSearch }}
                @endisset
            </div>
        </div>
    </form>
</div>
