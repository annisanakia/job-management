@extends('layouts.layout')
@section('content')

<div class="d-flex align-items-md-center flex-column flex-md-row pt-1 pb-3">
    <div>
        <h4 class="fw-bold mb-1">{{ $module_name }}</h4>
        <h6 class="op-7 mb-2">{{ $module_detail }}</h6>
    </div>
</div>
<form method="POST" action="{{ route($controller_name.'.update',$data->id) }}" class="form-validation" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="card rounded-top-0 mb-4">
                <div class="card-header">
                    <div class="card-title">About Employee</div>
                </div>
                <div class="card-body pb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NIP</label>
                                <input type="text" name="nip" class="form-control  @error('nip') is-invalid @enderror" value="{{ old('nip') ?? ($data->nip ?? null) }}" disabled>
                                @error('nip') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="asterisk">Name</label>
                                <input type="text" name="name" class="form-control  @error('name') is-invalid @enderror" value="{{ old('name') ?? ($data->name ?? null) }}" disabled>
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nickname</label>
                                <input type="text" name="nickname" class="form-control  @error('nickname') is-invalid @enderror" value="{{ old('nickname') ?? ($data->nickname ?? null) }}" disabled>
                                @error('nickname') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control  @error('email') is-invalid @enderror" value="{{ old('email') ?? ($data->email ?? null) }}" disabled>
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="number" name="phone" class="form-control  @error('phone') is-invalid @enderror" value="{{ old('phone') ?? ($data->phone ?? null) }}" disabled>
                                @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="asterisk">Job Position</label>
                                <select class="form-control form-select selectpicker @error('job_position_id') is-invalid @enderror" name="job_position_id" title="-- Select --" disabled>
                                    @foreach(\Models\job_position::select('name','id')->get() as $row)
                                        <option value="{{ $row->id }}" {{ (old('job_position_id') ?? ($data->job_position_id ?? null)) == $row->id? 'selected' : '' }}>{{ $row->name }}</option>
                                    @endforeach
                                </select>
                                @error('job_position_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="asterisk">Status</label>
                                <select class="form-control form-select selectpicker @error('status') is-invalid @enderror" name="status" title="-- Select --" disabled>
                                    @foreach(status() as $key => $name)
                                        <option value="{{ $key }}" {{ (old('status') ?? ($data->status ?? 1)) == $key? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card rounded-top-0 mb-4">
                <div class="card-header">
                    <div class="card-title">User Detail</div>
                </div>
                <div class="card-body pb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') ?? ($data->user->username ?? null) }}" disabled>
                                @error('username') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card rounded-top-0 mb-4">
                <div class="card-header">
                    <div class="card-title">Other Information</div>
                </div>
                <div class="card-body pb-4">
                    <div class="form-group">
                        <label>Profile Photo</label>
                        @if($data->url_photo ?? null)
                            <img src="{{ $data->url_photo }}" class="d-block object-fit-cover border rounded mb-3" width="120px" height="140px">
                        @else
                            
                            <div class="border rounded d-flex align-items-center justify-content-center bg-white text-body-tertiary" style="width:120px;height:140px;font-size:60px">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between">
        <a href="{{ url($controller_name) }}" class="btn btn-secondary"><i class="fas fa-chevron-left me-2"></i> Back</a>
    </div>
</form>

@endsection