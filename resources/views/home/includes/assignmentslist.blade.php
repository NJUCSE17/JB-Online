<div id="assignments">
    <div id="assignments-control">
        <p class="h3">
            当前作业
            <create-assignment-component
                    class="float-right"
                    :_api_personal="{{ json_encode(route('api.personalAssignment.store')) }}"
                    :_api_public="{{ json_encode(route('api.assignment.store')) }}"
            ></create-assignment-component>
        </p>
    </div>
    <hr/>
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