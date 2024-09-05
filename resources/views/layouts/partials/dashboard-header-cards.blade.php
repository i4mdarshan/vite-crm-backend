<!-- Header -->
<div class="row align-items-center py-2">
    <div class="col-lg-6 col-7">
    </div>
    <div class="col-lg-3 col-5"></div>
    <div class="col-lg-3 col-5 mb-2">
        <div id="reportrange"
            style="background: #fff; cursor: pointer; font-size:12px; border: 1px solid #ccc; width: 100%">
            <i class="fa fa-calendar"></i>&nbsp;
            <span></span> <i class="fa fa-caret-down"></i>
        </div>
    </div>
</div>

<!-- Card stats -->
<div id="master-count-stats">
    <div class="row mb-2">
        <div class="col-sm-6">
          <h3 class="mb-2 mx-2 my-2 link">Overall Info</h3>
        </div><!-- /.col -->
    </div>
    <div id="master_count_stats"></div>
</div>


@section('custom_scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            var start = moment().startOf('month');
            var end = moment().endOf('month');

            // Function to print selected date in html element
            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            // Enable daterangepicker on html element
            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                }
            }, cb);

            cb(start, end);


            var from_date = moment().startOf('month').format('YYYY-MM-DD');
            var to_date =  moment().endOf('month').format('YYYY-MM-DD');

            // prepare for ajax request
            var url = "{{ config("apiconfig.ajax_url") }}/home/stats";
            $.ajax({
                url: url,
                type: "POST",
                cache: false,
                data: {
                    _token: '{{ csrf_token() }}',
                    from_date: from_date,
                    to_date: to_date
                },
                dataType: 'json',
                success: function(dataResult) {
                    // console.log(dataResult);
                    $('#master_count_stats').html(dataResult.master_count_stats_html);
                    $('#quick_action_buttons_html').html(dataResult.quick_action_buttons_html);
                }
            });

            // Fetch new dashboard data on date range change
            $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
                var from_date = picker.startDate.format('YYYY-MM-DD');
                var to_date = picker.endDate.format('YYYY-MM-DD');

                // prepare for ajax request
                var url = "{{ config("apiconfig.ajax_url") }}/home/stats";
                $.ajax({
                    url: url,
                    type: "POST",
                    cache: false,
                    data: {
                        _token: '{{ csrf_token() }}',
                        from_date: from_date,
                        to_date: to_date
                    },
                    dataType: 'json',
                    success: function(dataResult) {
                        $('#master_count_stats').html(dataResult.master_count_stats_html);
                    }
                });
            });

        });
    </script>
@endsection

