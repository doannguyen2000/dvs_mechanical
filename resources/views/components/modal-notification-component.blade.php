@props(['modalId' => null])
<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true"
    data-type="">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="{{ $modalId }}Label">{{ __('DVS notification') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-start">
                <h6 class="modal-message"></h6>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary"
                    data-bs-dismiss="modal">{{ __('No') }}</button>
                <button type="button" id="buttonYes" class="btn btn-sm btn-primary">{{ __('Yes') }}</button>
            </div>
        </div>
    </div>
</div>
