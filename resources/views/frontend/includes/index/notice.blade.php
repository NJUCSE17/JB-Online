<div class="card my-3">
    <h4 class="card-header">
        <i class="fas fa-broadcast-tower mr-2"></i>
        {{ __('labels.frontend.home.notice') }}
        @auth
            @if(Auth::user()->isExecutive())
                <span class="float-right d-flex">
                    <a class="text-sm-center text-dark" href="{{ route('admin.forum.notice.index') }}">
                        <i class="fas fa-cog"></i>
                    </a>
                </span>
            @endif
        @endauth
    </h4>
    <div class="card-body text-justify" id="notice_content">
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