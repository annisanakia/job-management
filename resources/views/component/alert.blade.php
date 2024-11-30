<div class="bg-white p-5 d-flex justify-content-center align-items-center">
    <div class="text-center">
        <img src="{{ asset('assets/img/cat_detective.png') }}">
        <h3 class="mt-4"><i class="fas fa-exclamation-circle color-theme me-2"></i> {{ $title_message ?? 'Oops Sorry' }}</h3>
        <h5>{!! $text_message ?? 'Something Wrong' !!}</h5>
    </div>
</div>