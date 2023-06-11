@props(['modalId' => null, 'modalSize' => null])

<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label"
    aria-hidden="true">
    <div class="modal-dialog {{ $modalSize }}">
        <div class="modal-content">
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
