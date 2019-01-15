<div class="card my-3">
    <div class="card-body text-justify p-3" id="notice_content">
        @if($notice != null && $notice->content != null)
            {!! $notice->content !!}
            <p class="float-right text-muted">{{ $notice->time_label }}</p>
        @else
            <div class="row">
                <div class="col text-center">
                    {{ __('strings.frontend.home.no_notice') }}
                </div>
            </div>
        @endif
    </div>
</div>