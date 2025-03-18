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
                        <label class="asterisk">Date</label>
                        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') ?? ($data->date ?? date('Y-m-d')) }}">
                        @error('date') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Segment</label>
                        <select class="form-control form-select selectpicker @error('task_segment_id') is-invalid @enderror" name="task_segment_id" data-live-search="true" title="-- Select --">
                            @foreach(Models\task_segment::select('name','id')->get() as $row)
                                <option value="{{ $row->id }}" {{ (old('task_segment_id') ?? ($data->task_segment_id ?? null)) == $row->id? 'selected' : '' }}>{{ $row->name }}</option>
                            @endforeach
                        </select>
                        @error('task_segment_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control form-select selectpicker @error('task_category_id') is-invalid @enderror" name="task_category_id" data-live-search="true" title="-- Select --" id="task_category_id">
                            @foreach(Models\task_category::select('name','id')->get() as $row)
                                <option value="{{ $row->id }}" {{ (old('task_category_id') ?? ($data->task_category_id ?? null)) == $row->id? 'selected' : '' }}>{{ $row->name }}</option>
                            @endforeach
                        </select>
                        @error('task_category_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Job Type</label>
                        <select class="form-control form-select selectpicker @error('job_type_id') is-invalid @enderror" name="job_type_id" data-live-search="true" title="-- Select --" id="job_type_id">
                            @foreach(Models\job_type::select('name','id')->get() as $row)
                                <option value="{{ $row->id }}" {{ (old('job_type_id') ?? ($data->job_type_id ?? null)) == $row->id? 'selected' : '' }}>{{ $row->name }}</option>
                            @endforeach
                        </select>
                        @error('job_type_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="asterisk">Jobdesk</label>
                        <select id="task_reference_id" class="form-control form-select selectpicker @error('task_reference_id') is-invalid @enderror" name="task_reference_id" title="-- Select --" data-live-search="true">
                            <option value="">-- Select --</option>
                        </select>
                        @error('task_reference_id') <span class="text-danger">{{ $message }}</span> @enderror
                        <small class="form-text text-muted d-block">Please select category and job type before selecting jobdesk.</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="asterisk">SLA Duration</label>
                        <input type="text" name="sla_duration" class="form-control @error('sla_duration') is-invalid @enderror" value="{{ old('sla_duration') ?? null }}" id="sla_duration" readonly>
                        @error('sla_duration') <span class="text-danger">{{ $message }}</span> @enderror
                        <small class="form-text text-muted d-block">SLA Duration akan terisi jika sudah memilih Category dan Job Type.</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Detail</label>
                        <textarea name="detail" class="form-control @error('detail') is-invalid @enderror" rows="4">{{ old('detail') ?? ($data->detail ?? null) }}</textarea>
                        @error('detail') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="asterisk">Quantity</label>
                        <input type="text" name="quantity" class="form-control  @error('quantity') is-invalid @enderror" value="{{ old('quantity') ?? null }}">
                        @error('quantity') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Last Status</label>
                        <select class="form-control form-select selectpicker @error('group_id') is-invalid @enderror" name="task_status_id" data-live-search="true" title="-- Select --">
                            @foreach(Models\task_status::select('name','id')->get() as $row)
                                <option value="{{ $row->id }}" {{ (old('task_status_id') ?? ($data->task_status_id ?? 2)) == $row->id? 'selected' : '' }}>{{ $row->name }}</option>
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
                                <option value="{{ $row->id }}" {{ (old('periodic_type_id') ?? ($data->periodic_type_id ?? 1)) == $row->id? 'selected' : '' }}>{{ $row->name }}</option>
                            @endforeach
                        </select>
                        @error('periodic_type_id') <span class="text-danger">{{ $message }}</span> @enderror
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
                @if(session()->get('group_code') != 'EMP')
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Owner</label>
                            <select class="form-control form-select selectpicker @error('owner') is-invalid @enderror" name="owner" data-live-search="true" title="-- Select --">
                                @foreach($employees as $row)
                                    <option value="{{ $row->id }}" {{ (old('owner') ?? ($data->owner ?? $employee_id)) == $row->id? 'selected' : '' }}>{{ $row->name }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="pic" value="{{ $employee_id }}">
                            @error('owner') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                @else
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="asterisk">PIC</label>
                            <select class="form-control form-select selectpicker @error('pic') is-invalid @enderror" name="pic" data-live-search="true" title="-- Select --">
                                @foreach($supervisors as $row)
                                    <option value="{{ $row->id }}" {{ (old('pic') ?? ($data->pic ?? $employee_id)) == $row->id? 'selected' : '' }}>{{ $row->name }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="owner" value="{{ $employee_id }}">
                            @error('pic') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                @endif
            </div>
            <div class="d-grid gap-2 d-md-block my-2 text-end">
                @include('component.actions')
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("#task_category_id").change(function (e) {
            getSLA($(this).val(), $("#job_type_id").val());
        });

        $("#job_type_id").change(function (e) {
            getSLA($("#task_category_id").val(), $(this).val());
        });

        getSLA("{{ old('task_category_id') ?? ($data->task_category_id ?? null) }}", "{{ old('job_type_id') ?? ($data->job_type_id ?? null) }}", "{{ old('task_reference_id') ?? ($data->task_reference_id ?? null) }}")
        function getSLA(task_category_id, job_type_id, id){
            var url = "{{ url($controller_name.'/getSLA') }}",
                target = '#task_reference_id',
                data = {
                    task_category_id: task_category_id,
                    job_type_id: job_type_id,
                    id: id,
                    blank: true
                };

            $.ajax({
                url: url,
                type: 'GET',
                data: data,
                success: function(data) { 
                    $(target).html(data);
                    $('.selectpicker').selectpicker('refresh');
                },
                error: function (e) {
                    swalDeleteButtons.fire(
                        'Warning !',
                        'Something Wrong',
                        'error'
                    );
                }
            });
            $('#task_reference_id').val(id);
        }

        setDuration("{{ old('task_reference_id') ?? ($data->task_reference_id ?? null) }}")
        function setDuration(task_reference_id){
            var url = "{{ url($controller_name.'/setDuration') }}",
                data = {
                    task_reference_id: task_reference_id
                };
            
            $.ajax({
                url: url,
                type: 'GET',
                data: data,
                success: function(data) { 
                    $('#sla_duration').val(data.sla_duration);
                },
                error: function (e) {
                    swalDeleteButtons.fire(
                        'Warning !',
                        'Something Wrong',
                        'error'
                    );
                }
            });
        }

        $("#task_reference_id").change(function (e) {
            setDuration($(this).val());
        });
    });
</script>

@endsection