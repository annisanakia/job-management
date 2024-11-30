@extends('layouts.app')
@section('content_app')
<main class="bg-body-secondary login">
    <div class="container">
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center m-0">
                    <div class="col-lg-12 col-md-6 d-flex flex-column align-items-center justify-content-center">
                        <div class="card mb-3">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-lg-6 d-lg-flex align-items-center justify-content-center pe-lg-0 d-none">
                                        <div class="logo">
                                            <img src="{{ asset('assets/img/management-people.jpg') }}" alt="" class="w-100 rounded object-fit-cover" style="height: 600px;">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 d-flex align-items-center col-lg-6 d-flex align-items-center ps-lg-0">
                                    <div class="p-lg-5 p-4 m-lg-3 m-xl-5">
                                        <div class="py-4 logo d-flex justify-content-center px-xl-5 px-md-0 px-sm-5 fs-2 text-primary fw-bold">
                                            Job Management
                                        </div>
                                        <div class="pb-2">
                                            <h5 class="card-title text-center pb-0 fs-4">Sign In</h5>
                                        </div>
                                        <form class="row g-3 needs-validation" method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <div class="col-12 {{ $errors->has('username') ? ' is-invalid' : '' }}">
                                                <label for="yourUsername" class="form-label">Username</label>
                                                <div class="input-group has-validation">
                                                    <span class="input-group-text"><i class="fas fa-solid fa-user"></i></span>
                                                    <input type="text" name="username" class="form-control {{ $errors->first('username')? 'is-invalid' : null }}" id="yourUsername">
                                                    <div class="invalid-feedback">{{ $errors->first('username') }}</div>
                                                </div>
                                            </div>
                                            <div class="col-12 {{ $errors->has('username') ? ' is-invalid' : '' }}">
                                                <label for="yourPassword" class="form-label">Password</label>
                                                <div class="input-group has-validation">
                                                    <span class="input-group-text"><i class="fas fa-solid fa-key"></i></span>
                                                    <input type="password" name="password" class="form-control {{ $errors->first('password')? 'is-invalid' : null }}" id="yourPassword">
                                                    <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                                </div>
                                            </div>
                                            @if($errors->has('user_valid'))
                                            <div class="col-12">
                                                <div class="alert alert-danger" role="alert">
                                                    {{ $errors->first('user_valid') }}
                                                </div>
                                            </div>
                                            @endif
                                            <div class="col-12 my-4">
                                                <button class="btn btn-primary w-100 rounded btn-loading" type="submit">Login</button>
                                                <div class="small mt-3 text-center">Copyright (c) 2024 Raza</div>
                                            </div>
                                        </form>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main><!-- End #main -->
@endsection