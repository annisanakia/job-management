@extends('layouts.layout')
@section('content')

<div class="d-flex align-items-md-center flex-column flex-md-row pt-1 pb-3">
    <div>
        <h4 class="fw-bold mb-1">{{ $module_name }}</h4>
        <h6 class="op-7 mb-2">{{ $module_detail }}</h6>
    </div>
</div>

@if($data->employee)
    @include(ucwords($controller_name).'::detailEmployee')
@endif

<div class="card">
    <div class="card-header">
        <div class="card-title">Data Detail</div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="asterisk">Username</label>
                    <input type="text" name="username" class="form-control  @error('username') is-invalid @enderror" value="{{ old('username') ?? $data->username }}" disabled>
                    @error('username') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-6"></div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="asterisk">Name</label>
                    <input type="text" name="name" class="form-control  @error('name') is-invalid @enderror" value="{{ old('name') ?? $data->name }}" disabled>
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="asterisk">Email</label>
                    <input type="text" name="email" class="form-control  @error('email') is-invalid @enderror" value="{{ old('email') ?? $data->email }}" disabled>
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <?php
                $groups = Models\group::select('name','id')->where('code','ADM')->get();
                if($data->employee){
                    $groups = Models\group::select('name','id')->get();
                }
            ?>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="asterisk">Group</label>
                    <select class="form-control form-select selectpicker @error('group_id') is-invalid @enderror" name="group_id" data-live-search="true" title="-- Select --" disabled>
                        @foreach($groups as $row)
                            <option value="{{ $row->id }}" {{ (old('group_id') ?? ($data->group_id ?? null)) == $row->id? 'selected' : '' }}>{{ $row->name }}</option>
                        @endforeach
                    </select>
                    @error('group_id') <span class="text-danger">{{ $message }}</span> @enderror
                    <small class="form-text text-muted d-block">Job position access groups.</small>
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
        <div class="d-grid gap-2 d-md-block my-2 text-end">
            @include('component.actions')
        </div>
    </div>
</div>

@endsection