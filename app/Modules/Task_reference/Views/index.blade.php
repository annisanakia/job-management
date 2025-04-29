@extends('layouts.layout')
@section('content')

<div class="d-flex align-items-md-center flex-column flex-md-row pt-1 pb-3">
    <div>
        <h4 class="fw-bold mb-1">{{ $module_name }}</h4>
        <h6 class="op-7 mb-2">{{ $module_detail }}</h6>
    </div>
</div>
<div id="container" class="position-relative">
    @include(ucwords($controller_name).'::list')
</div>

@include('component.skeleton.skeleton')
@endsection