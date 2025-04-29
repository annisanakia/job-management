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
        <form method="POST" action="{{ route($controller_name.'.store') }}" class="form-validation" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="asterisk">Jobdesk</label>
                        <input type="text" name="jobdesk" class="form-control  @error('jobdesk') is-invalid @enderror" value="{{ old('jobdesk') ?? ($data->jobdesk ?? null) }}">
                        @error('jobdesk') <span class="text-danger">{{ $message }}</span> @enderror
                        <small class="form-text text-muted d-block">Default based on email.</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Performance</label>
                        <input type="text" name="performance" class="form-control  @error('performance') is-invalid @enderror" value="{{ old('performance') ?? ($data->performance ?? null) }}">
                        @error('performance') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="asterisk">Category</label>
                        <select class="form-control form-select selectpicker @error('task_category_id') is-invalid @enderror" name="task_category_id" data-live-search="true" title="-- Select --">
                            @foreach(Models\task_category::select('name','id')->get() as $row)
                                <option value="{{ $row->id }}" {{ (old('task_category_id') ?? ($data->task_category_id ?? null)) == $row->id? 'selected' : '' }}>{{ $row->name }}</option>
                            @endforeach
                        </select>
                        @error('task_category_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="asterisk">Job Type</label>
                        <select class="form-control form-select selectpicker @error('job_type_id') is-invalid @enderror" name="job_type_id" data-live-search="true" title="-- Select --">
                            @foreach(Models\job_type::select('name','id')->get() as $row)
                                <option value="{{ $row->id }}" {{ (old('job_type_id') ?? ($data->job_type_id ?? null)) == $row->id? 'selected' : '' }}>{{ $row->name }}</option>
                            @endforeach
                        </select>
                        @error('job_type_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                    /* karyawan bisa liat total task berdasarkan supervisornya
                    supervisor bisa liat total task berdasarkan karayawannya */
                    $employee = \Models\employee::select('employee.id','employee.name','job_position.code')
                            ->leftJoin('job_position', function ($join){
                                $join->on('job_position.id', '=', 'employee.job_position_id')->whereNull('job_position.deleted_at');
                            })->get();
                    $employees = $employee->where('code','EMP');
                    $supervisors = $employee->where('code','SPV');

                    $staff_ids = old('staff_ids') ?? (isset($data)? $data->task_reference_staffs->pluck('employee_id')->all() : []);
                    $msco_ids = old('msco_ids') ?? (isset($data)? $data->task_reference_mscos->pluck('employee_id')->all() : []);
                ?>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="asterisk">Staff</label>
                        <select class="form-control form-select selectpicker @error('staff_ids') is-invalid @enderror" name="staff_ids[]" data-live-search="true" title="-- Select --" data-actions-box="true" data-selected-text-format="count" multiple>
                            @foreach($employees as $row)
                                <option value="{{ $row->id }}" {{ in_array($row->id,$staff_ids)? 'selected' : '' }}>{{ $row->name }}</option>
                            @endforeach
                        </select>
                        @error('staff_ids') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="asterisk">MSCO</label>
                        <select class="form-control form-select selectpicker @error('msco_ids') is-invalid @enderror" name="msco_ids[]" data-live-search="true" title="-- Select --" data-actions-box="true" data-selected-text-format="count" multiple>
                            @foreach($supervisors as $row)
                                <option value="{{ $row->id }}" {{ in_array($row->id,$msco_ids)? 'selected' : '' }}>{{ $row->name }}</option>
                            @endforeach
                        </select>
                        @error('msco_ids') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="asterisk">SLA Duration</label>
                        <input type="text" name="sla_duration" class="form-control @error('sla_duration') is-invalid @enderror" value="{{ old('sla_duration') ?? ($data->sla_duration ?? null) }}" id="sla_duration">
                        @error('sla_duration') <span class="text-danger">{{ $message }}</span> @enderror
                        <small class="form-text text-muted d-block">SLA Duration akan terisi jika sudah memilih Category dan Job Type. Duration dalam menit</small>
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