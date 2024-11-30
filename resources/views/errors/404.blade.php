@extends('layouts.app')
@section('content_app')
<main>
    <div class="container">
        <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center text-center">
            <i class="fas fa-exclamation-triangle mb-4 text-danger" style="font-size:80px"></i>
            <h1 class="fs-1 fw-semibold">404 Not Found</h1>
            <h4>Sorry the page you requested cannot be found.</h4>
            <a class="btn btn-secondary my-2" href="{{ url('/') }}">Back to home</a>
            <div class="credits mt-4 small-text">
                &copy; Copyright 2024. All Rights Reserved
            </div>
        </section>
    </div>
</main><!-- End #main -->
@endsection