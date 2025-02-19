<div class="col-md-12 position-relative">
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-chart-bar me-1"></i>
            Grafik Mingguan Koordinator
        </div>
        <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
    </div>
    <div class="card">

        <form method="GET" action="{{ url($controller_name.'/getReport?'.http_build_query($param)) }}" accept-charset="UTF-8" class="form-validation-ajax" data-target="#container">
        <input type="hidden" name="sort_field" value="{{ $sort_field }}" class="order-input">
        <input type="hidden" name="sort_type" value="{{ $sort_type }}" class="order-input">
        <div class="card-body">
            <div class="row row-gap-3">
                <div class="col-md-6">
                    <div class="d-flex flex-row align-items-center">
                        Show <input type="number" name="max_row" class="form-control mx-2" value="{{ $max_row }}" style="width:70px"> entries
                    </div>
                </div>
                <div class="col-md-6">
                    @include('component.actions')
                </div>
            </div>
            <div class="table-responsive mt-3">
                <table class="table table-striped">
                    <thead>
                    <tr class="thead">
                        <th width="40px" class="text-center">No</th>
                        <th class="order-link {{ ($sort_field == 'date'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'?sort_field=date&sort_type='.($sort_field == 'date'? $sort_type : 0)+1) }}">
                            Date
                        </th>
                        <th class="order-link {{ ($sort_field == 'task_segment_id'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'/getReport?'.http_build_query($param).'&sort_field=task_segment_id&sort_type='.($sort_field == 'task_segment_id'? $sort_type : 0)+1) }}">
                            Segment
                        </th>
                        <th class="order-link {{ ($sort_field == 'task_category_id'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'/getReport?'.http_build_query($param).'&sort_field=task_category_id&sort_type='.($sort_field == 'task_category_id'? $sort_type : 0)+1) }}">
                            Category
                        </th>
                        <th class="order-link {{ ($sort_field == 'detail'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'/getReport?'.http_build_query($param).'&sort_field=detail&sort_type='.($sort_field == 'detail'? $sort_type : 0)+1) }}">
                            Detail
                        </th>
                        <th class="order-link {{ ($sort_field == 'task_status_id'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'/getReport?'.http_build_query($param).'&sort_field=task_status_id&sort_type='.($sort_field == 'task_status_id'? $sort_type : 0)+1) }}">
                            Last Status
                        </th>
                        @if($position_code == 'SPV')
                            <th class="order-link {{ ($sort_field == 'owner'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'/getReport?'.http_build_query($param).'&sort_field=owner&sort_type='.($sort_field == 'owner'? $sort_type : 0)+1) }}">
                                Owner
                            </th>
                        @else
                            <th class="order-link {{ ($sort_field == 'pic'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'/getReport?'.http_build_query($param).'&sort_field=pic&sort_type='.($sort_field == 'pic'? $sort_type : 0)+1) }}">
                                PIC
                            </th>
                        @endif
                    </tr>
                    <tr>
                        <th class="text-center"><button type="submit" class="btn btn-light border"><i class="fas fa-search"></i></button></th>
                        <th><input type="date" name="filters[date]" class="form-control" value="{{ $filters['date'] ?? null }}"></th>
                        <th>
                            <select class="form-control form-select " name="filters[task_segment_id]"  title="-- Select --">
                                <option value="">-- Select --</option>
                                @foreach(Models\task_segment::select('name','id')->orderBy('name')->get() as $row)
                                    <option value="{{ $row->id }}" {{ ($filters['task_segment_id'] ?? null) == $row->id? 'selected' : '' }}>{{ $row->name ?? null }}</option>
                                @endforeach
                            </select>
                        </th>
                        <th>
                            <select class="form-control form-select " name="filters[task_category_id]"  title="-- Select --">
                                <option value="">-- Select --</option>
                                @foreach(Models\task_category::select('name','id')->orderBy('name')->get() as $row)
                                    <option value="{{ $row->id }}" {{ ($filters['task_category_id'] ?? null) == $row->id? 'selected' : '' }}>{{ $row->name ?? null }}</option>
                                @endforeach
                            </select>
                        </th>
                        <th><input type="text" name="filters[detail]" class="form-control" value="{{ $filters['detail'] ?? null }}"></th>
                        <th>
                            <select class="form-control form-select " name="filters[task_status_id]"  title="-- Select --">
                                <option value="">-- Select --</option>
                                @foreach(Models\task_status::select('name','id')->orderBy('name')->get() as $row)
                                    <option value="{{ $row->id }}" {{ ($filters['task_status_id'] ?? null) == $row->id? 'selected' : '' }}>{{ $row->name ?? null }}</option>
                                @endforeach
                            </select>
                        </th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; ?>
                        @forelse ($datas as $data)
                            <tr>
                                <td class="text-center">{{ (($datas->currentPage() - 1 ) * $datas->perPage() ) + ++$i }}.</td>
                                <td>{{dateToIndo($data->date ?? null)}}</td>
                                <td>{{$data->task_segment->name ?? null}}</td>
                                <td>{{$data->task_category->name ?? null}}</td>
                                <td>{{$data->detail}}</td>
                                <td>{{$data->task_status->name ?? null}}</td>
                                @if($position_code == 'SPV')
                                    <td>{{$data->employee_owner->name ?? null}}</td>
                                @else
                                    <td>{{$data->employee_pic->name ?? null}}</td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" align="center">
                                    Data Not Found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="table-list-footer">
                Showing {{$datas->firstItem()}} to {{$datas->lastItem()}} of {{$datas->total()}} entries
                {{ $datas->appends(request()->all())->links('component.pagination')}}
            </div>
        </div>
        </form>
    </div>
</div>
<script src="{{ asset('assets/js/app.js') }}"></script>
<script type="text/javascript">
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#292b2c';

    // Bar Chart Example
    var ctx = document.getElementById("myBarChart");
    var myLineChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($datas_graph['labels'] ?? []) !!},
        datasets: [{
            label: "Complete",
            backgroundColor: "rgb(115, 228, 120)",
            borderColor: "rgba(115, 228, 120)",
            data: {!! json_encode($datas_graph['datasets_complete'] ?? []) !!},
        },{
            label: "Not Complete",
            backgroundColor: "rgb(224, 97, 97)",
            borderColor: "rgb(224, 97, 97)",
            data: {!! json_encode($datas_graph['datasets_notcomplete'] ?? []) !!},
        }],
    },
    options: {
        scales: {
        xAxes: [{
            time: {
            unit: 'month'
            },
            gridLines: {
            display: false
            },
            ticks: {
            maxTicksLimit: 25
            }
        }],
        yAxes: [{
            ticks: {
            min: 0,
            maxTicksLimit: 5
            },
            gridLines: {
            display: true
            }
        }],
        },
        legend: {
        display: false
        }
    }
    });
</script>