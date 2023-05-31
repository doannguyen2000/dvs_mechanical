@extends('layouts.main-app')

@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body text-start">
                <h5 class="card-title">Users list</h5>
                <hr>
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4 border text-center">
                            <div class="container mt-2">
                                <img src="{{ asset('assets/images/adminAvatar.jpg') }}" class="img-fluid rounded border"
                                    alt="...">
                                <div class="row">
                                    <div class="col-12">
                                        <p>name: Đoàn đức nguyên</p>
                                        <p>date of birth: 01-01-2000</p>
                                        <p>Position: Admin</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">User information</h5>
                                <form class="row g-3">
                                    <div class="col-sm-6">
                                        <label for="inputFirstName" class="form-label">First name</label>
                                        <input type="text" class="form-control" id="inputFirstName" name="firstName">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="inputLastName" class="form-label">Last name</label>
                                        <input type="text" class="form-control" id="inputLastName" name="lastName">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="inputUserName" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="inputUserName" name="lastName">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="inputEmail" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="inputEmail" name="email">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="inputPhone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" id="inputPhone" name="phoneNumber">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="inputDateOfBirth" class="form-label">Phone</label>
                                        <input type="date" class="form-control" id="inputDateOfBirth" name="DateOfBirth">
                                    </div>
                                    <div class="col-12">
                                        <label for="inputAddress" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="inputAddress"
                                            placeholder="1234 Main St">
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
