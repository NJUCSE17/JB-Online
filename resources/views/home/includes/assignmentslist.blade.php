<div id="assignments">
    <div id="assignments-control">
        <p class="h3">当前作业</p>
    </div>
    <hr />
    <div id="assignments-content">
        @if(count($assignments))
            @foreach($assignments as $assignment)
                @include('home.includes.assignment', ['assignment' => $assignment])
            @endforeach
        @else
            <p class="text-center my-4">现在没有作业。</p>
        @endif
    </div>
</div>