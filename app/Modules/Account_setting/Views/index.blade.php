@extends('layouts.layout')
@section('content')

<div class="d-flex align-items-md-center flex-column flex-md-row pt-1 pb-3">
    <div>
        <h4 class="fw-bold mb-1">{{ 'Account Setting' }}</h4>
    </div>
</div>
<section class="section profile">
    <div class="row">
        <div class="col-xl-4">
            <div class="card py-4">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    @if(($data->url_photo ?? null) != '' && $data->employee)
                        <img src="{{ asset($data->url_photo) }}" alt="Profile" class="rounded-circle border object-fit-cover" style="width: 130px;height: 130px">
                    @else
                        <div class="rounded-circle border d-flex align-items-center justify-content-center fs-1" style="width: 130px;height: 130px;">
                            {{ getInitials($data->name) }}
                        </div>
                    @endif
                    <h4 class="mb-0 mt-3">{{ $data->name }}</h4>
                    <h5>{{ $data->group->name ?? null }}</h5>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered">
                        <li class="nav-item">
                            <button class="nav-link {{ !in_array(Session::get('type'),[1,2])? 'active' : ''  }}" data-bs-toggle="tab" data-bs-target="#profile-overview">Profile Information</button>
                        </li>
                        @if($data->employee)
                            <li class="nav-item">
                                <button class="nav-link {{ Session::get('type') == 1? 'active' : ''  }}" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                            </li>
                        @endif
                        <li class="nav-item">
                            <button class="nav-link {{ Session::get('type') == 2? 'active' : ''  }}" data-bs-toggle="tab" data-bs-target="#profile-change-password">Update Password</button>
                        </li>
                    </ul>
                    <div class="tab-content py-4">
                        <div class="tab-pane fade {{ !in_array(Session::get('type'),[1,2])? 'show active' : ''  }}" id="profile-overview">
                            <h5 class="card-title mb-2">Detail Profil</h5>
                            <div class="row mb-2">
                                <div class="col-lg-3 col-md-4 label">Username</div>
                                <div class="col-lg-9 col-md-8 fw-semibold">{{ $data->username }}</div>
                            </div>
                            @if($data->employee)
                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">NIP</div>
                                    <div class="col-lg-9 col-md-8 fw-semibold">{{ $data->employee->nip ?? null }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Nickname</div>
                                    <div class="col-lg-9 col-md-8 fw-semibold">{{ $data->employee->nickname ?? null }}</div>
                                </div>
                            @endif
                            <div class="row mb-2">
                                <div class="col-lg-3 col-md-4 label">Email</div>
                                <div class="col-lg-9 col-md-8 fw-semibold">{{ $data->email }}</div>
                            </div>
                            @if($data->employee)
                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Phone</div>
                                    <div class="col-lg-9 col-md-8 fw-semibold">{{ $data->employee->phone ?? null }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Division</div>
                                    <div class="col-lg-9 col-md-8 fw-semibold">{{ $data->employee->department_active->department->division->name ?? null }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Department</div>
                                    <div class="col-lg-9 col-md-8 fw-semibold">{{ $data->employee->department_active->department->name ?? null }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Position</div>
                                    <div class="col-lg-9 col-md-8 fw-semibold">{{ $data->employee->position_active->job_position->name ?? null }}</div>
                                </div>
                            @endif
                        </div>
                        @if($data->employee)
                        <div class="tab-pane fade {{ Session::get('type') == 1? 'show active' : ''  }}" id="profile-edit">
                            <!-- Profile Edit Form -->
                            <form method="POST" action="{{ route($controller_name.'.update',$data->id) }}" class="form-validation update" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="col-form-label">Nickname</label>
                                            <input name="nickname" type="text" class="form-control {{ $errors->has('nickname')? 'is-invalid' : '' }}" value="{{ old('nickname') ?? $data->employee->nickname }}">
                                            {!!$errors->first('nickname', ' <span class="invalid-feedback">:message</span>')!!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="col-form-label">Phone</label>
                                            <input name="phone" type="number" class="form-control {{ $errors->has('phone')? 'is-invalid' : '' }}" value="{{ old('phone') ?? $data->employee->phone }}">
                                            {!!$errors->first('phone', ' <span class="invalid-feedback">:message</span>')!!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="col-form-label">Profile Photo</label>
                                            @if($data->url_photo ?? null)
                                                <div class="py-2">
                                                    <a href="{{ route($controller_name.'.delete_img',($data->id ?? null)) }}" class="btn btn-outline-danger btn-sm delete" style="width:120px;">
                                                        Delete Image <i class="ms-1 fas fa-trash"></i>
                                                    </a>
                                                </div>
                                                <img src="{{ $data->url_photo }}" class="d-block object-fit-cover border rounded mb-3" width="120px" height="140px">
                                            @endif
                                            <input name="url_photo" class="form-control @error('url_photo') is-invalid @enderror" type="file">
                                            <small class="form-text text-muted d-block">Upload file with format image.<br>Size maximal file 2Mb.</small>
                                            {!!$errors->first('url_photo', ' <span class="invalid-feedback">:message</span>')!!}
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid gap-2 d-md-block my-2 text-end">
                                    <button type="submit" class="btn btn-outline-success px-3 btn-submit">
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                        @endif

                        <div class="tab-pane fade {{ Session::get('type') == 2? 'show active' : ''  }}" id="profile-change-password">
                            <!-- Change Password Form -->
                            <form method="POST" action="{{ route($controller_name.'.update_password',$data->id) }}" class="form-validation update_password" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="col-form-label">Current Password</label>
                                            <input name="current_password" type="password" class="form-control {{ $errors->has('current_password')? 'is-invalid' : '' }}" value="{{ old('current_password') }}">
                                            {!!$errors->first('current_password', ' <span class="invalid-feedback">:message</span>')!!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="col-form-label">Username</label>
                                            <input name="username" type="text" class="form-control {{ $errors->has('username')? 'is-invalid' : '' }}" value="{{ old('username') ?? $data->username }}" disabled>
                                            {!!$errors->first('username', ' <span class="invalid-feedback">:message</span>')!!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="col-form-label">New Password</label>
                                            <input name="password" type="password" class="form-control {{ $errors->has('password')? 'is-invalid' : '' }}" value="{{ old('password') }}">
                                            {!!$errors->first('password', ' <span class="invalid-feedback">:message</span>')!!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="col-form-label">Confirm New Password</label>
                                            <input name="password_confirmation" type="password" class="form-control {{ $errors->has('password_confirmation')? 'is-invalid' : '' }}" value="{{ old('password_confirmation') }}">
                                            {!!$errors->first('password_confirmation', ' <span class="invalid-feedback">:message</span>')!!}
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid gap-2 d-md-block my-2 text-end">
                                    <button type="submit" class="btn btn-outline-success px-3 btn-submit">
                                        Save Password
                                    </button>
                                </div>
                            </form><!-- End Change Password Form -->
                        </div>
                    </div><!-- End Bordered Tabs -->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script type="text/javascript">
    @if(Session::get('success') == 1)
        swalSaveButtons.fire('Saved Successfully!', '', 'success')
    @endif
    $(".btn-submit").click(function (e) {
        e.preventDefault();

        e.stopPropagation();
        e.stopImmediatePropagation();

        swalSaveButtons.fire({
            title: 'Save changes?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Save',
            cancelButtonText: 'Cancel',
            reverseButtons: true
            }).then((result) => {
            if (result.isConfirmed) {
                $(this).closest("form").submit();
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {}
        });
    });
</script>
@endsection