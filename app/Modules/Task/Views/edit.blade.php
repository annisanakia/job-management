@extends('layouts.layout')
@section('content')

<div class="d-flex align-items-md-center flex-column flex-md-row pt-1 pb-3">
    <div>
        <h4 class="fw-bold mb-1">{{ $module_name }}</h4>
        <h6 class="op-7 mb-2">{{ $module_detail }}</h6>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">New Data</div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route($controller_name.'.update',$data->id) }}" class="form-validation" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Segment</label>
                        <select class="form-control form-select selectpicker @error('group_id') is-invalid @enderror" name="task_segment_id" data-live-search="true" title="-- Select --">
                            @foreach(Models\task_segment::select('name','id')->get() as $row)
                                <option value="{{ $row->id }}" {{ (old('task_segment_id') ?? ($data->task_segment_id ?? null)) == $row->id? 'selected' : '' }}>{{ $row->name }}</option>
                            @endforeach
                        </select>
                        @error('task_segment_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control form-select selectpicker @error('group_id') is-invalid @enderror" name="task_category_id" data-live-search="true" title="-- Select --">
                            @foreach(Models\task_category::select('name','id')->get() as $row)
                                <option value="{{ $row->id }}" {{ (old('task_category_id') ?? ($data->task_category_id ?? null)) == $row->id? 'selected' : '' }}>{{ $row->name }}</option>
                            @endforeach
                        </select>
                        @error('task_category_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="asterisk">Detail</label>
                        <textarea name="detail" class="form-control @error('detail') is-invalid @enderror" rows="4">{{ old('detail') ?? ($data->detail ?? null) }}</textarea>
                        @error('detail') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="text" name="quantity" class="form-control  @error('quantity') is-invalid @enderror" value="{{ old('quantity') ?? ($data->quantity ?? null) }}">
                        @error('quantity') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Job Type</label>
                        <select class="form-control form-select selectpicker @error('group_id') is-invalid @enderror" name="job_type_id" data-live-search="true" title="-- Select --">
                            @foreach(Models\job_type::select('name','id')->get() as $row)
                                <option value="{{ $row->id }}" {{ (old('job_type_id') ?? ($data->job_type_id ?? null)) == $row->id? 'selected' : '' }}>{{ $row->name }}</option>
                            @endforeach
                        </select>
                        @error('job_type_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Last Status</label>
                        <select class="form-control form-select selectpicker @error('group_id') is-invalid @enderror" name="task_status_id" data-live-search="true" title="-- Select --">
                            @foreach(Models\task_status::select('name','id')->get() as $row)
                                <option value="{{ $row->id }}" {{ (old('task_status_id') ?? ($data->task_status_id ?? null)) == $row->id? 'selected' : '' }}>{{ $row->name }}</option>
                            @endforeach
                        </select>
                        @error('task_status_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Periodic Type</label>
                        <select class="form-control form-select selectpicker @error('periodic_type_id') is-invalid @enderror" name="periodic_type_id" data-live-search="true" title="-- Select --">
                            @foreach(Models\periodic_type::select('name','id')->get() as $row)
                                <option value="{{ $row->id }}" {{ (old('periodic_type_id') ?? ($data->periodic_type_id ?? null)) == $row->id? 'selected' : '' }}>{{ $row->name }}</option>
                            @endforeach
                        </select>
                        @error('periodic_type_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <?php
                /* karyawan bisa liat total task berdasarkan supervisornya
                supervisor bisa liat total task berdasarkan karayawannya */
                $employee = \Models\employee::select('employee.id','employee.name','job_position.code')
                        ->leftJoin('job_position', function ($join){
                            $join->on('job_position.id', '=', 'employee.job_position_id')->whereNull('job_position.deleted_at');
                        })->get();
                $employees = $employee->where('code','EMP');
                $supervisors = $employee->where('code','SPV');
            ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>PIC</label>
                        <select class="form-control form-select selectpicker @error('pic') is-invalid @enderror" name="pic" data-live-search="true" title="-- Select --">
                            @foreach($supervisors as $row)
                                <option value="{{ $row->id }}" {{ (old('pic') ?? ($data->pic ?? null)) == $row->id? 'selected' : '' }}>{{ $row->name }}</option>
                            @endforeach
                        </select>
                        @error('pic') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Owner</label>
                        <select class="form-control form-select selectpicker @error('owner') is-invalid @enderror" name="owner" data-live-search="true" title="-- Select --">
                            @foreach($employees as $row)
                                <option value="{{ $row->id }}" {{ (old('owner') ?? ($data->owner ?? null)) == $row->id? 'selected' : '' }}>{{ $row->name }}</option>
                            @endforeach
                        </select>
                        @error('owner') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="d-grid gap-2 d-md-block my-2 text-end">
                @include('component.actions')
            </div>
        </form>
    </div>
</div>

@endsection