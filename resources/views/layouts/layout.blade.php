@extends('layouts.app')
@section('content_app')

<div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
                <a href="{{ url('/') }}" class="logo text-white">
                    Job Management
                </a>
                <div class="nav-toggle">
                    <button class="btn btn-toggle d-lg-flex justify-content-center align-items-center toggle-sidebar" style="width:40px;height:40px">
                        <i class="mx-auto gg-menu-right"></i>
                    </button>
                    <button class="btn btn-toggle sidenav-toggler">
                        <i class="gg-menu-left"></i>
                    </button>
                </div>
                <button class="topbar-toggler more d-flex align-items-center justify-content-center" style="width: 30px;height: 30px;">
                    <i class="gg-more-vertical-alt"></i>
                </button>
            </div>
            <!-- End Logo Header -->
        </div>

        <!-- Start Sidebar -->
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
            <div class="sidebar-content">
                <?php
                    $photo_profile = Auth::user()->employee->url_photo ?? null;
                ?>
                <div class="side-profile text-center m-4">
                    @if($photo_profile)
                        <div class="avatar d-block mx-auto mb-3">
                            <img src="{{ $photo_profile }}" class="avatar-title rounded-circle object-fit-cover">
                        </div>
                    @else
                        <div class="avatar d-block mx-auto mb-3">
                            <span class="avatar-title rounded-circle">{{ getInitials(Auth::user()->name) }}</span>
                        </div>
                    @endif
                    <h5 class="mb-1 profile-title">{{ Auth::user()->name }}</h5>
                    <span class="profile-subtitle">{{ Auth::user()->group->name ?? null }}</span>
                </div>
                <?php
                    $menus = new \Lib\core\Sidemenu();
                    $menus->listMenu();
                ?>
                {!! $menus->listMenu() !!}
            </div>
        </div>
    </div>
    <!-- End Sidebar -->

    <div class="main-panel">
        <div class="main-header">
            <div class="main-header-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="dark">
                    <a href="{{ url('/') }}" class="logo">
                        <img src="{{ asset('assets/img/admin/logo_light.svg') }}" alt="navbar brand" class="navbar-brand" height="40"/>
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle d-lg-flex justify-content-center align-items-center toggle-sidebar" style="width:40px;height:40px">
                            <i class="mx-auto gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                    <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                    </button>
                </div>
                <!-- End Logo Header -->
            </div>

            <!-- Navbar Header -->
            <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                <div class="container-fluid">
                <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                    <li class="nav-item topbar-icon dropdown hidden-caret">
                        <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bell"></i>
                            @if((session()->get('total_notifications') ?? 0) > 0)
                                <span class="notification">{{ session()->get('total_notifications') }}</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu messages-notif-box animated fadeIn" aria-labelledby="messageDropdown">
                            <li>
                                <div class="dropdown-title d-flex justify-content-between align-items-center">
                                    Notifications
                                    @if((session()->get('total_notifications') ?? 0) > 0)
                                        <a href="{{ url('notification/markAllRead') }}" class="text-end small fw-bold color-theme">
                                            Mark all as read ({{ session()->get('total_notifications') }})
                                        </a>
                                    @endif
                                </div>
                            </li>
                            <li>
                                <div class="message-notif-scroll scrollbar-outer">
                                    <div class="notif-center" id="notification">
                                    </div>
                                </div>
                            </li>
                                <a class="see-all" href="{{ url('notification') }}">View all notifications<i class="fa fa-angle-right"></i></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item topbar-icon dropdown hidden-caret submenu">
                        {{-- <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bell"></i>
                            @if((session()->get('total_notifications') ?? 0) > 0)
                                <span class="notification">{{ session()->get('total_notifications') }}</span>
                            @endif
                        </a> --}}
                        <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                            <li class="dropdown-title">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        Notifications
                                    </div>
                                    @if((session()->get('total_notifications') ?? 0) > 0)
                                        <a href="{{ url('notification/markAllRead') }}" class="text-end small fw-bold color-theme">
                                            Mark all as read ({{ session()->get('total_notifications') }})
                                        </a>
                                    @endif
                                </div>
                            </li>
                            <li id="notification"></li>
                            <li>
                                <a class="see-all" href="{{ url('notification') }}">View all notifications<i class="fa fa-angle-right"></i></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item topbar-user dropdown hidden-caret">
                        <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                            @if($photo_profile)
                                <div class="avatar d-block">
                                    <img src="{{ $photo_profile }}" class="avatar-title rounded-circle border object-fit-cover">
                                </div>
                            @else
                                <div class="avatar d-block">
                                    <span class="avatar-title rounded-circle">{{ getInitials(Auth::user()->name) }}</span>
                                </div>
                            @endif
                            <span class="profile-username">
                                <span class="op-7">Hi,</span>
                                <span class="fw-bold">{{ Auth::user()->employee->nickname ?? (getFirstName(Auth::user()->name)) }}</span>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li>
                                <div class="user-box">
                                    <div>
                                        @if($photo_profile)
                                        <div class="avatar-lg d-block">
                                                <img src="{{ $photo_profile }}" class="avatar-title rounded border object-fit-cover">
                                            </div>
                                        @else
                                            <div class="avatar-lg d-block">
                                                <span class="avatar-title rounded">{{ getInitials(Auth::user()->name) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="u-text">
                                        <h4>{{ Auth::user()->name }}</h4>
                                        <p class="text-muted text-nowrap">{{ Auth::user()->email }}</p>
                                        <a href="{{ url('account_setting') }}" class="btn btn-xs btn-info btn-sm">
                                            <i class="fas fa-cog me-1"></i> Account Setting
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="fas fa-power-off me-2"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>
        <div class="container">
            <div class="page-inner">
                @yield('content')
            </div>
        </div>
        <footer class="footer">
            <div class="container-fluid d-flex justify-content-center">
                <div class="copyright">
                    &copy; Copyright 2024. All Rights Reserved
                </div>
            </div>
        </footer>
    </div>
</div>
@endsection