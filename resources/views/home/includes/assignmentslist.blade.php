<div id="assignments">
    <div id="assignments-control">
        <p>当前作业</p>
    </div>
    <hr />
    <div id="assignments-content">
        @foreach($assignments as $assignment)
            @include('home.includes.assignment', ['assignment' => $assignment])
        @endforeach
    </div>
</div>