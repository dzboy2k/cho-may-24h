@extends("admin.layout.main")
@section('title','Dashboard')
@section('page_content')
    <div class="padding-4 container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="my-3">
                    <h5 class="m-0 text-black">{{__('admin.report_total')}}</h5>
                    <p class="m-0">{{__('admin.sub_report')}}</p>
                </div>
                <div class="row padding-1">
                    <div class="m-0 col-12 col-md-6 padding-1">
                        <div class="bg-white rounded padding-2 shadow">
                            <h5 class="subtitle text-black">{{__('admin.total_user')}}</h5>
                            <h5 class="text-primary">{{$user_count}} {{__('admin.user')}}</h5>
                        </div>
                    </div>
                    <div class="m-0 col-12 col-md-6 padding-1">
                        <div class="bg-white rounded padding-2 shadow rounded">
                            <h5 class="subtitle text-black">{{__('admin.total_post')}}</h5>
                            <h5 class="text-primary">{{$post_count}} {{__('admin.post')}}</h5>
                        </div>
                    </div>
                    <div class="m-0 col-12 col-md-6 padding-1">
                        <div class="bg-white rounded padding-2 shadow rounded">
                            <h5 class="subtitle text-black">{{__('admin.total_success_transaction')}}</h5>
                            <h5 class="text-warning">{{$successfully_transaction_count}} {{__('admin.transaction')}}</h5>
                        </div>
                    </div>
                    <div class="m-0 col-12 col-md-6 padding-1">
                        <div class="bg-white rounded padding-2 shadow rounded">
                            <h5 class="subtitle text-black">{{__('admin.total_unverify_post')}}</h5>
                            <h5 class="text-warning">{{$unverify_post_count}} {{__('admin.post')}}</h5>
                        </div>
                    </div>
                    <div class="m-0 col-12 col-md-6 padding-1">
                        <div class="bg-white rounded padding-2 shadow rounded">
                            <h5 class="subtitle text-black">{{__('admin.total_charge')}}</h5>
                            <h5 class="text-primary">{{$total_charge}} {{__('admin.vnd')}}</h5>
                        </div>
                    </div>
                    <div class="m-0 col-12 col-md-6 padding-1">
                        <div class="bg-white rounded padding-2 shadow rounded">
                            <h5 class="subtitle text-black">{{__('admin.total_consuming_support')}}</h5>
                            <h5 class="text-primary">{{@$site->total_consuming_support}} {{__('admin.vnd')}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-6">
                <div class="my-3">
                    <h5 class="m-0 text-black">{{__('admin.report_chart')}}</h5>
                    <p class="m-0">{{__('admin.sub_report_chart')}}</p>
                    <div class="row my-3">
                        <div class="w-100 bg-white rounded padding-2 my-1" id="charge-chart-container">
                            <canvas id="charge-chart"></canvas>
                            <h5 class="subtitle text-center my-3 text-black">{{__('admin.total_charge_table',['year'=>\Illuminate\Support\Carbon::now()->year])}}</h5>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection
{{-- @section('js')
    <script>
        const chargeChartContainer = document.getElementById('charge-chart-container');
        (async function () {

            const resp = await fetch('{{route('admin.charge.data')}}', {
                method: 'GET'
            });
            const jsonData = await resp.json();
            const data = jsonData.map((val, index) => ({month: MONTHS[index], count: val}));
            if (data.length === 0) {
                chargeChartContainer.innerHTML = `<p class="subtitle text-center text-black my-3">{{__('admin.no_data')}}</p>`;
                return;
            }
            const chargeCanvas = document.getElementById('charge-chart');
            renderChart(data, chargeCanvas, {
                row_label: 'month',
                row_value: 'count',
                type: 'bar',
                label: '{{__('admin.total_charge')}}',
                bg: '#3fadfc',
                options: {
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            })
        })();
    </script>
@endsection --}}
