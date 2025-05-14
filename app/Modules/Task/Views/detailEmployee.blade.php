<?php
    $employee = $data->employee;
?>
<div class="card">
    <div class="card-header">
        <div class="card-title">Detail Employee</div>
    </div>
    <div class="card-body">
        <div class="d-md-flex align-items-center mx-4">
            @if($employee->user->url_photo ?? null)
                <img src="{{ $employee->user->url_photo }}" class="d-block object-fit-cover border rounded" width="120px" height="120px">
            @else
                <div class="border rounded d-flex align-items-center justify-content-center bg-white text-body-tertiary" style="width:120px;height:120px;font-size:60px">
                    <i class="fas fa-image"></i>
                </div>
            @endif
            <div class="ms-md-4 flex-grow-1">
                <h6 class="mb-0 mx-2 mt-4 mt-lg-2">{{ $employee->nip ?? null }}</h6>
                <h4 class="mb-0 mx-2">{{ $employee->name ?? null }}</h4>
                <hr class="my-2">
                <div class="row px-2">
                    <div class="col-lg-3 col-md-6 mb-2">
                        Division<br>
                        <b>{{ $employee->department_active->department->division->name ?? null }}</b>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-2">
                        Department<br>
                        <b>{{ $employee->department_active->department->name ?? null }}</b>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-2">
                        Job Position<br>
                        <b>{{ $employee->position_active->job_position->name ?? null }}</b>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-2">
                        Status<br>
                        <b>{{ status()[$employee->status] ?? null }}</b>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>