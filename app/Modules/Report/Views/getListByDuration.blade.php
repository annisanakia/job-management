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
                       <th class="order-link {{ ($sort_field == 'name'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'/getReport?sort_field=name&sort_type='.($sort_field == 'name'? $sort_type : 0)+1) }}">
                           Name
                       </th>
                       <th class="order-link {{ ($sort_field == 'total_duration'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'/getReport?'.http_build_query($param).'&sort_field=total_duration&sort_type='.($sort_field == 'total_duration'? $sort_type : 0)+1) }}">
                           Total Task Duration
                       </th>
                       <th class="order-link {{ ($sort_field == 'total_sla_duration'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'/getReport?'.http_build_query($param).'&sort_field=total_sla_duration&sort_type='.($sort_field == 'total_sla_duration'? $sort_type : 0)+1) }}">
                           Total SLA Duration
                       </th>
                       <th class="order-link {{ ($sort_field == 'total_task'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'/getReport?'.http_build_query($param).'&sort_field=total_task&sort_type='.($sort_field == 'total_task'? $sort_type : 0)+1) }}">
                           Total Task
                       </th>
                   </tr>
                   </thead>
                   <tbody>
                       <?php $i = 0; ?>
                       @forelse ($datas as $data)
                           <tr>
                               <td class="text-center">{{ (($datas->currentPage() - 1 ) * $datas->perPage() ) + ++$i }}.</td>
                               <td>{{$data->name ?? null}}</td>
                               <td>{{$data->total_duration ?? null}}</td>
                               <td>{{$data->total_sla_duration ?? null}}</td>
                               <td>{{$data->total_task ?? null}}</td>
                           </tr>
                       @empty
                           <tr>
                               <td colspan="5" align="center">
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
           label: "Total Task Duration",
           backgroundColor: "rgb(115, 228, 120)",
           borderColor: "rgba(115, 228, 120)",
           data: {!! json_encode($datas_graph['datasets'] ?? []) !!},
       }]
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