<div class="card mb-3">
    <h5 class="card-header text-center py-2">
        <i class="fas fa-broadcast-tower mr-2"></i>
        {{ __('labels.frontend.home.notice') }}
    </h5>
    <div class="card-body text-justify p-3" id="notice_content">
        @if($notice != null && $notice->content != null)
            {!! $notice->content_html !!}
            <p class="float-right text-muted my-0">{{ $notice->time_label }}</p>
        @else
            <div class="row">
                <div class="col text-center">
                    {{ __('strings.frontend.home.no_notice') }}
                </div>
            </div>
        @endif
    </div>
</div>