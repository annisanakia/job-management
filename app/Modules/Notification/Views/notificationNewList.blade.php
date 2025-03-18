@forelse($notifications as $notification)
    <?php
        $timestamp = strtotime($notification->datetime);
    ?>
    <a href="{{ url('notification/notificationDetail/'.$notification->id) }}" class="align-items-center {{ $notification->is_read != 1? 'bg-light-blue' : null }}">
        <div>
            <div class="notif-icon notif-primary">
                <i class="fas fa-user-edit"></i>
            </div>
        </div>
        <div class="notif-content">
            <span class="block fw-bold">{!! $notification->title !!}</span>
            <span class="block fs-px-11">{!! $notification->message !!}</span>
            <span class="time">{{ ((time()-$timestamp)/86400) < 2? get_time_ago($timestamp) : concatDayAndDate($notification->datetime).' '.date('H:i', $timestamp) }}</span>
        </div>
    </a>
@empty
    <div class="p-3 text-body-secondary text-center">No Notifications</div>
@endforelse
