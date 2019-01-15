<div class="card my-3">
    <div class="card-body text-center p-3" id="notice_content"
        style="overflow: hidden;">
        <div id="cal-heatmap" class="m-0 text-center" style="width: 100%; overflow: hidden;"></div>

        @push('after-scripts')
            <script type="text/javascript">
                let cal = new CalHeatMap();
                let date = new Date();
                //date.setMonth(date.getMonth() - 1);

                cal.init({
                    domain: "month",
                    subDomain: "x_day",
                    itemName: "assignment",
                    start: date,
                    data: "{{ route("api.heatmap") }}"
                        + "?userID={{ Auth::user()->id }}&st=\{\{t:start\}\}&ed=\{\{t:end\}\}",
                    cellSize: 15,
                    cellPadding: 5,
                    domainGutter: 20,
                    previousSelector: "#heatmap-prev",
                    nextSelector: "#heatmap-next",
                    legend: [1, 2, 3, 4, 5],
                    legendCellSize: 12,
                    legendCellPadding: 5,
                    legendVerticalPosition: "top",
                    domainLabelFormat: "%Y-%m",
                    label: {
                        position: "top",
                    },
                    domainDynamicDimension: false,
                });
            </script>
        @endpush
    </div>
</div>