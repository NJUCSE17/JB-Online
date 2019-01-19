<div class="card mb-3">
    <h5 class="card-header text-center py-2">
        <i class="fas fa-fire-alt mr-2"></i>
        {{ __('labels.frontend.home.heatmap') }}
    </h5>
    <div class="card-body text-center px-3 pt-3 pb-0" id="notice_content"
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
    <div class="card-footer text-center py-2">
        <div class="row py-0">
            <div class="col py-0">
                <button class="btn py-0" id="heatmap-prev">
                    <i class="fas fa-arrow-left"></i>
                </button>
            </div>
            <div class="col">
                <button class="btn py-0" id="heatmap-next">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>