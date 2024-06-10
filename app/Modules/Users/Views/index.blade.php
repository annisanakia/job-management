@extends('layouts.layout')

@section('content')
<div class="container-fluid px-4">
    <h2 class="my-4">Daftar Pengguna</h2>
    <section class="section">
        @include(ucwords($controller_name).'::list')
    </section>
</div>
@endsection