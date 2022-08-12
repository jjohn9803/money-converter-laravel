<div class="row" style="margin-bottom: 20px;">
    <form action="/admin/" method="POST">
        @csrf
        <div class="box-header pull-left ">
            <div class="col-sm-8">
                <div class="input-group input-group-sm">

                    {{-- <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div> --}}
                    <input type="date" class="form-control" id="created_at" placeholder="Date" value={{ $s }}
                        name="created_at" autocomplete="off">

                    <div class="input-group-addon"><i class="fa fa-arrows-h"></i></div>
                    {{-- <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div> --}}
                    <input type="date" class="form-control" id="created_at" placeholder="Date"
                        value={{ $t }} name="to_at" autocomplete="off">
                </div>

            </div>
            <div class="col-sm-4">
                <div class="col text-left">
                    <button class="btn btn-info submit btn-sm"><span
                            class="fa fa-search"></span>&nbsp;&nbsp;{{ __('admin.custom.dashboard.search') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>
{{-- <div class="row">
    <div class="col-xs-12 center-block text-center">
        <h1>{{ Carbon\Carbon::parse($s)->format('d-m-Y') }}</h1>
        <h2>to</h2>
        <h1>{{ Carbon\Carbon::parse($t)->format('d-m-Y') }}</h1>
    </div>
</div> --}}

<div class="row">
    <div class="col-lg-4 col-xs-4">
        <!-- small box -->
        <div class="small-box bg-teal">
            <div class="inner">
                <h3>{{ $dailyTransactions->count() }}</h3>

                <p>{{ __('admin.custom.dashboard.t_counts') }}</p>
            </div>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-xs-4">
        <!-- small box -->
        <div class="small-box bg-purple-active color-palette">
            <div class="inner">
                <h3>{{ $dailyAcceptedTransactions->count() }}</h3>

                <p>{{ __('admin.custom.dashboard.at_counts') }}</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-xs-4">
        <!-- small box -->
        <div class="small-box bg-red disabled color-palette">
            <div class="inner">
                <h3>{{ $dailyRejectedTransactions->count() }}</h3>

                <p>{{ __('admin.custom.dashboard.rt_counts') }}</p>
            </div>
        </div>
    </div>
    <!-- ./col -->
</div>

<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-purple-active color-palette">
            <div class="inner">
                <h3>{{ $dailyPopularBaseFx }}</h3>

                <p>{{ __('admin.custom.dashboard.pbf_counts') }}</p>
            </div>
        </div>
    </div>
    <!-- ./col -->

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red disabled color-palette">
            <div class="inner">
                <h3>{{ $dailyPopularResultFx }}</h3>

                <p>{{ __('admin.custom.dashboard.prf_counts') }}</p>
            </div>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green-active disabled color-palette">
            <div class="inner">
                <h3>{{ $dailyUsers->count() }}</h3>

                <p>{{ __('admin.custom.dashboard.t_user') }}</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow-active disabled color-palette">
            <div class="inner">
                <h3>{{ $TotalUsers->count() }}</h3>

                <p>{{ __('admin.custom.dashboard.tr_user') }}</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <!-- small box -->
        <div class="small-box">
            {{ view('admin.charts.bar')
            ->with('data', $canvasTransactions)
            ->with('data_x', 'my_date')
            ->with('data_y', 'total_count')
            ->with('data_label', __('admin.custom.dashboard.t_counts')) }}
        </div>
    </div>
    <div class="col-lg-4">
        <!-- small box -->
        <div class="small-box">
            {{ view('admin.charts.bar')
            ->with('data', $canvasAcceptedTransactions)
            ->with('data_x', 'my_date')
            ->with('data_y', 'total_count')
            ->with('data_label', __('admin.custom.dashboard.at_counts')) }}
        </div>
    </div>
    <div class="col-lg-4">
        <!-- small box -->
        <div class="small-box">
            {{ view('admin.charts.bar')
            ->with('data', $canvasRejectedTransactions)
            ->with('data_x', 'my_date')
            ->with('data_y', 'total_count')
            ->with('data_label', __('admin.custom.dashboard.rt_counts')) }}
        </div>
    </div>
</div>