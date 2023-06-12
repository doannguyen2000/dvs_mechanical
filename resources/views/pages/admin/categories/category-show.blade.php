@extends($showModal ? 'layouts.modal-app' : 'layouts.main-app')

@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body text-start">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title">{{ __('Category Show') }}</h5>
                    <a class="icon-link icon-link-hover"
                        @if ($showModal) data-bs-dismiss="modal"
                        aria-label="Close" @else href="{{ route('admin.categories.list') }}" @endif>
                        <i class="fa-regular fa-circle-left"></i>
                        </span>
                        {{ __('Back') }}
                    </a>
                </div>
                <hr>
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-6 border rounded">
                            <div class="card-body">
                                <h5 class="card-title">{{ __('Permission information') }}</h5>
                                <hr>
                            </div>
                        </div>
                        <div class="col-md-6 border rounded">
                            <div class="card-body">
                                <h5 class="card-title">{{ __('Roles') }}</h5>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
