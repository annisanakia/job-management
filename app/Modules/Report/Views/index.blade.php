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
        <div class="card-title">Report Job</div>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route($controller_name.'.getReport') }}" class="form-validation-ajax" enctype="multipart/form-data">
            <input type="hidden" name="owner" value="{{ old('owner') ?? Auth::user()->id }}">
            @csrf
            <?php
                $task_segments = \Models\task_segment::select('id','name')->pluck('name','id')->all();
                $task_statuses = \Models\task_status::select('id','name')->pluck('name','id')->all();
                
                /* karyawan bisa liat total task berdasarkan supervisornya
                supervisor bisa liat total task berdasarkan karayawannya */
                $employee = \Models\employee::select('employee.id','employee.name','job_position.code')
                        ->leftJoin('job_position', function ($join){
                            $join->on('job_position.id', '=', 'employee.job_position_id')->whereNull('job_position.deleted_at');
                        })->get();
                $employees = $employee->where('code','EMP')->pluck('name','id')->all();
                $supervisors = $employee->where('code','SPV')->pluck('name','id')->all();
            ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Report By</label>
                        <select class="form-control form-select selectpicker @error('report_by') is-invalid @enderror" name="report_by" title="-- Select --">
                            @foreach(reportBy() as $key => $value)
                                <option value="{{ $key }}" {{ (old('report_by') ?? ($report_by ?? 1)) == $key? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                @if($position_code == 'SPV')
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Employee</label>
                            <select class="form-control form-select selectpicker @error('employee_ids') is-invalid @enderror" name="employee_ids[]" data-live-search="true" title="-- All --" multiple="true" data-actions-box="true" data-selected-text-format="count">
                                @foreach($employees as $key => $value)
                                    <option value="{{ $key }}" {{ in_array($key, (old('employee_ids') ?? ($employee_ids ?? [])))? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @else
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Supervisor</label>
                            <select class="form-control form-select selectpicker @error('supervisor_ids') is-invalid @enderror" name="supervisor_ids[]" data-live-search="true" title="-- All --" multiple="true" data-actions-box="true" data-selected-text-format="count">
                                @foreach($supervisors as $key => $value)
                                    <option value="{{ $key }}" {{ in_array($key, (old('supervisor_ids') ?? ($supervisor_ids ?? [])))? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control form-select selectpicker @error('task_status_ids') is-invalid @enderror" name="task_status_ids[]" data-live-search="true" title="-- All --" multiple="true" data-actions-box="true" data-selected-text-format="count">
                            @foreach($task_statuses as $key => $value)
                                <option value="{{ $key }}" {{ in_array($key, (old('task_status_ids') ?? ($task_status_ids ?? [])))? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>From Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $start_date ?? null }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>To Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $end_date ?? null }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-end">
                    <button type="submit" class="btn btn-primary px-3 ms-md-1" id="" data-url="#">
                        <i class="fas fa-search me-1"></i> Search
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="container" class="position-relative">
    <div class="alert alert-info">
        Pilih kriteria untuk menampilkan hasil laporan
    </div>
</div>

@include('component.skeleton.skeleton')

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/chart.min.js') }}" crossorigin="anonymous"></script>
@endsection