@props(['modalId' => null, 'modalSize' => null, 'modalTitle' => null])

<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label"
    aria-hidden="true">
    <div class="modal-dialog {{ $modalSize }} modal-dialog-centered">
        <div class="modal-content">
            @if ($modalTitle !== null)
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $modalTitle }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            @endif
            <div class="modal-body">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
