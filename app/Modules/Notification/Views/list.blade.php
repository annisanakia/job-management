<div class="col-md-12 position-relative">
    <div class="card">
        <form method="GET" action="{{ url($controller_name) }}" accept-charset="UTF-8" class="form-validation-ajax" data-target="#container">
        <input type="hidden" name="sort_field" value="{{ $sort_field }}" class="order-input">
        <input type="hidden" name="sort_type" value="{{ $sort_type }}" class="order-input">
        <div class="card-body py-0">
            <div class="row">
                <div class="col-md-12 border-bottom d-flex justify-content-between align-items-center">
                    <div class="text-center py-3">
                        You have {{ session()->get('total_notifications', 0) }} unread notifications
                    </div>
                    @if(session()->get('total_notifications', 0) > 0)
                    <div class="text-end py-3">
                        <a href="{{ url($controller_name.'/markAllRead') }}" class="text-end small fw-bold color-theme d-flex justify-content-end align-items-center">
                            Mark all as read ({{ session()->get('total_notifications', 0) }}) <i class="ms-1 fas fa-circle" style="font-size: 6px"></i>
                        </a>
                    </div>
                    @endif
                </div>
                @forelse ($datas as $data)
                    <?php
                        $timestamp = strtotime($data->datetime);
                    ?>
                    <div class="col-md-12 border-bottom panel-hover {{ $data->is_read != 1? 'bg-light-blue' : null }}">
                        <a href="{{ url('notification/notificationDetail/'.$data->id) }}" class="my-3 d-flex align-items-center">
                            <div>
                                <div class="d-flex mx-3 justify-content-center align-items-center rounded-circle text-white bg-primary" style="width:50px;height:50px">
                                    <i class="fs-4 fas fa-user-edit"></i>
                                </div>
                            </div>
                            <div class="notif-content">
                                <div class="fw-bold">{!! $data->title !!}</div>
                                <div>{!! $data->message !!}</div>
                                <div class="small text-dark-emphasis">{{ ((time()-$timestamp)/86400) < 2? get_time_ago($timestamp) : concatDayAndDate($data->datetime).' '.date('H:i', $timestamp) }}</div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-md-12 text-center py-2">
                        No Notifications
                    </div>
                @endforelse
            </div>
            <div class="text-center py-2 pt-3">
                Showing {{$datas->firstItem()}} to {{$datas->lastItem()}} of {{$datas->total()}} entries
                {{ $datas->appends(request()->all())->links('component.pagination')}}
            </div>
        </div>
        </form>
    </div>
</div>

<script src="{{ asset('assets/js/app.js') }}"></script>