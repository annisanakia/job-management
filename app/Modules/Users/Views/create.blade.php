@extends('layouts.layout')

@section('content')

<div class="container-fluid px-4">
    <h2 class="my-4">Daftar Pengguna</h2>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

            <form method="POST" action="{{ route($controller_name.'.store') }}" class="form-validation" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                    <h5 class="card-title">Tambah Data</h5>
                    <div class="d-grid gap-2 d-md-block my-2 text-end">
                        @include('component.actions')
                    </div>
                    <!-- General Form Elements -->
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="col-form-label">Name</label>
                                <input name="name" type="text" class="form-control {{ $errors->has('name')? 'is-invalid' : '' }}" value="{{ old('name') }}">
                                {!!$errors->first('name', ' <span class="invalid-feedback">:message</span>')!!}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="col-form-label">Email</label>
                                <input name="email" type="text" class="form-control {{ $errors->has('email')? 'is-invalid' : '' }}" value="{{ old('email') }}">
                                {!!$errors->first('email', ' <span class="invalid-feedback">:message</span>')!!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="col-form-label">Username</label>
                                <input name="username" type="text" class="form-control {{ $errors->has('username')? 'is-invalid' : '' }}" value="{{ old('username') }}">
                                {!!$errors->first('username', ' <span class="invalid-feedback">:message</span>')!!}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="col-form-label">Password</label>
                                <input name="password" type="password" class="form-control {{ $errors->has('password')? 'is-invalid' : '' }}" value="{{ old('password') }}">
                                {!!$errors->first('password', ' <span class="invalid-feedback">:message</span>')!!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="col-form-label">Grup pengguna</label>
                                <select name="groups_id" class="form-select {{ $errors->has('groups_id')? 'is-invalid' : '' }}">
                                    <option value="" selected>-- Pilih --</option>
                                    @foreach(\Models\groups::all() as $row)
                                        <option value="{{ $row->id }}" {{ $row->id == old('groups_id')? 'selected' : '' }}>{{ $row->name }}</option>
                                    @endforeach
                                </select>
                                {!!$errors->first('groups_id', ' <span class="invalid-feedback">:message</span>')!!}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="col-form-label">Nomor Telepon</label>
                                <input name="phone_no" type="text" class="form-control {{ $errors->has('phone_no')? 'is-invalid' : '' }}" value="{{ old('phone_no') }}">
                                {!!$errors->first('phone_no', ' <span class="invalid-feedback">:message</span>')!!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="col-form-label">Foto Profil</label>
                            <input name="url_photo" class="form-control {{ $errors->has('url_photo')? 'is-invalid' : '' }}" type="file">
                            <div class="form-text">Upload file berformat JPEG, PNG, JPG.<br>Maksimal ukuran file 2 Mb.</div>
                            {!!$errors->first('url_photo', ' <span class="invalid-feedback">:message</span>')!!}
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="col-form-label">Status</label>
                                <select name="status" class="form-select {{ $errors->has('status')? 'is-invalid' : '' }}">
                                    <option value="" selected>-- Pilih --</option>
                                    <option value="1" {{ 1 == (old('status') ?? 1)? 'selected' : '' }}>Aktif</option>
                                    <option value="2" {{ 2 == (old('status') ?? 1)? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                                {!!$errors->first('status', ' <span class="invalid-feedback">:message</span>')!!}
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-select/1.13.14/css/bootstrap-select.min.css')}}">
<script src="{{ asset('assets/plugins/bootstrap-select/v1.14.0-beta2/bootstrap-select.js')}}"></script>
<script type="text/javascript">
    $('.selectpicker').selectpicker('refresh');
</script>
@endsection