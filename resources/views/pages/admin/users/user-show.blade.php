@extends($showModal ? 'layouts.modal-app' : 'layouts.main-app')

@section('content')
    <div class="card {{ $showModal ? '' : 'mt-4' }} bg-body-tertiary">
        <div class="card-body text-start">
            <div class="d-flex justify-content-between">
                <h5 class="card-title">{{ __('Users Show') }}</h5>
                <a role="button" class="icon-link icon-link-hover"
                    @if ($showModal) data-bs-dismiss="modal"
                        aria-label="Close" @else href="{{ route('admin.users.list') }}" @endif>
                    <i class="fa-regular fa-circle-left"></i>
                    </span>
                    {{ __('Back') }}
                </a>
            </div>
            <hr>
            <div class="card mb-3">
                <form
                    @if (!$showModal) action="{{ route('admin.users.update', ['id' => $user->id]) }}" method="POST"
                        enctype="multipart/form-data" @endif>
                    @csrf
                    <div class="row g-0">
                        <div class="col-lg-4 text-center">
                            <div class="container mt-2 mb-2  position-relative">
                                <input type="file" onchange="showImage('imgAvatarUser','inputAvataUser')"
                                    id="inputAvataUser" name='file_avatar' hidden>
                                <img id="imgAvatarUser"
                                    src="@if (!empty($user->avatar)) {{ asset(Storage::url($user->avatar)) }}@else{{ asset('assets/images/adminAvatar.jpg') }} @endif"
                                    class="img-fluid rounded border border-5 border-dark w-100" alt="...">
                                @if (!$showModal)
                                    <button type="button"
                                        class="btn btn-primary btn-sm position-absolute top-0 end-0 me-2"><i
                                            class="fa-solid fa-pen-to-square"
                                            onclick="$('#inputAvataUser').click();"></i></button>
                                @endif
                                <div class="mt-2 text-start">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span>{{ __('Name:') }}</span><span>{{ $user->full_name ?? '' }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <span>{{ __('Date of birth:') }}</span><span>{{ $user->date_of_birth ?? '' }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <span>{{ __('Role:') }}</span>
                                            <span>{!! $user->role->role_icon ?? '' !!}&nbsp;{{ $user->role->role_name ?? '' }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 border rounded bg-body-secondary">
                            <div class="card-body">
                                <h5 class="card-title">User information</h5>
                                <div class="row g-3">
                                    @php
                                        if (!empty($user->full_name)) {
                                            $parts = explode(' ', $user->full_name);
                                            $firstname = end($parts);
                                            array_pop($parts); // Loại bỏ phần tử cuối cùng trong mảng
                                            $lastElement = implode(' ', $parts);
                                        }
                                    @endphp
                                    <div class="col-sm-6">
                                        <label for="inputFirstName" class="form-label">{{ __('First name') }}</label>
                                        <input type="text"
                                            class="form-control @if ($showModal) bg-primary-subtle border border-primary @endif"
                                            id="inputFirstName" value="{{ $firstname ?? '' }}" name="first_name"
                                            @if ($showModal) disabled @endif>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="inputLastName" class="form-label">{{ __('Last name') }}</label>
                                        <input type="text"
                                            class="form-control @if ($showModal) bg-primary-subtle border border-primary @endif"
                                            id="inputLastName" value="{{ $lastElement ?? '' }}" name="last_name"
                                            @if ($showModal) disabled @endif>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="inputUserName" class="form-label">{{ __('username') }}</label>
                                        <input type="text"
                                            class="form-control @if ($showModal) bg-primary-subtle border border-primary @endif"
                                            id="inputUserName" value="{{ $user->name }}" name="name"
                                            @if ($showModal) disabled @endif>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="inputEmail" class="form-label">{{ __('email') }}</label>
                                        <input type="email"
                                            class="form-control @if ($showModal) bg-primary-subtle border border-primary @endif"
                                            id="inputEmail" value="{{ $user->email }}" name="email"
                                            @if ($showModal) disabled @endif>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="inputPhone" class="form-label">{{ __('Phone') }}</label>
                                        <input type="text"
                                            class="form-control @if ($showModal) bg-primary-subtle border border-primary @endif"
                                            id="inputPhone" value="{{ $user->phone }}" name="phone"
                                            @if ($showModal) disabled @endif>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="inputDateOfBirth" class="form-label">{{ __('Date Of Birth') }}</label>
                                        <input type="date"
                                            class="form-control @if ($showModal) bg-primary-subtle border border-primary @endif"
                                            id="inputDateOfBirth" value="{{ $user->date_of_birth }}" name="date_of_birth"
                                            @if ($showModal) disabled @endif>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-6 col-xl-4 mb-3">
                                                <label for="selectProvince" class="form-label">province</label>
                                                <select
                                                    class="form-select  @if ($showModal) bg-primary-subtle border border-primary @endif"
                                                    id="selectProvince" name="province"
                                                    @if ($showModal) disabled @endif>
                                                </select>
                                            </div>
                                            <div class="col-md-6 col-xl-4 mb-3">
                                                <label for="selectDistrict" class="form-label">district</label>
                                                <select
                                                    class="form-select  @if ($showModal) bg-primary-subtle border border-primary @endif"
                                                    id="selectDistrict" name="district"
                                                    @if ($showModal) disabled @endif>
                                                </select>
                                            </div>
                                            <div class="col-md-6 col-xl-4 mb-3">
                                                <label for="selectWard" class="form-label">ward</label>
                                                <select
                                                    class="form-select  @if ($showModal) bg-primary-subtle border border-primary @endif"
                                                    id="selectWard" name="ward"
                                                    @if ($showModal) disabled @endif>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-between">
                                        @if (!$showModal)
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        @else
                                            <a class="btn btn-primary" href="{{ Request::url() }}"><span><i
                                                        class="fa-solid fa-file-pen"></i></span>
                                                {{ __('Update now') }}</a>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                                aria-label="Close">Close</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('style-js')
    <script>
        $(document).ready(function() {
            getProvince();

            $('#selectProvince').change(function() {
                getDistrict();
            });

            $('#selectDistrict').change(function() {
                getWard();
            });


            function getProvince() {
                getJsonFileAddress("", "", "", "{{ asset('assets/datas/addrres.json') }}")
                    .then(function(data) {
                        renderOption('selectProvince', data,
                            "{{ $user->address }}");
                        if ($('#selectProvince').val() != null) {
                            getDistrict();

                        }
                    })
                    .catch(function(error) {
                        alert("Lỗi trong quá trình yêu cầu Ajax:", error);
                    });
            }

            function getDistrict() {
                getJsonFileAddress($('#selectProvince').val(), "", "",
                        "{{ asset('assets/datas/addrres.json') }}")
                    .then(function(data) {
                        renderOption('selectDistrict', data,
                            "{{ $user->address }}");
                        getWard();
                    })
                    .catch(function(error) {
                        alert("Lỗi trong quá trình yêu cầu Ajax:", error);
                    });
            }

            function getWard() {
                getJsonFileAddress($('#selectProvince').val(), $('#selectDistrict').val(), "",
                        "{{ asset('assets/datas/addrres.json') }}")
                    .then(function(data) {
                        renderOption('selectWard', data,
                            "{{ $user->address }}");
                    })
                    .catch(function(error) {
                        alert("Lỗi trong quá trình yêu cầu Ajax:", error);
                    });
            }
        });
    </script>
@endsection
