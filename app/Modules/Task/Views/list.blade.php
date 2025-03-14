<div class="col-md-12 position-relative">
    <div class="card">

        <form method="GET" action="{{ url($controller_name) }}" accept-charset="UTF-8" class="form-validation-ajax" data-target="#container">
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
                        <th class="order-link {{ ($sort_field == 'task_category_id'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'?sort_field=task_category_id&sort_type='.($sort_field == 'task_category_id'? $sort_type : 0)+1) }}">
                            Category
                        </th>
                        <th class="order-link {{ ($sort_field == 'jobdesk'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'?sort_field=jobdesk&sort_type='.($sort_field == 'jobdesk'? $sort_type : 0)+1) }}">
                            Jobdesk
                        </th>
                        <th class="order-link {{ ($sort_field == 'task_status_id'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'?sort_field=task_status_id&sort_type='.($sort_field == 'task_status_id'? $sort_type : 0)+1) }}">
                            Last Status
                        </th>
                        @if($position_code == 'SPV')
                            <th class="order-link {{ ($sort_field == 'owner'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'?sort_field=owner&sort_type='.($sort_field == 'owner'? $sort_type : 0)+1) }}">
                                Owner
                            </th>
                        @else
                            <th class="order-link {{ ($sort_field == 'pic'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'?sort_field=pic&sort_type='.($sort_field == 'pic'? $sort_type : 0)+1) }}">
                                PIC
                            </th>
                        @endif
                        <th class="order-link {{ ($sort_field == 'sla_duration'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'?sort_field=sla_duration&sort_type='.($sort_field == 'sla_duration'? $sort_type : 0)+1) }}">
                            SLA Duration
                        </th>
                        <th class="order-link {{ ($sort_field == 'quantity'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'?sort_field=quantity&sort_type='.($sort_field == 'quantity'? $sort_type : 0)+1) }}">
                            Quantity
                        </th>
                        <th class="order-link {{ ($sort_field == 'start_date'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'?sort_field=start_date&sort_type='.($sort_field == 'start_date'? $sort_type : 0)+1) }}">
                            Start
                        </th>
                        <th class="order-link {{ ($sort_field == 'end_date'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'?sort_field=end_date&sort_type='.($sort_field == 'end_date'? $sort_type : 0)+1) }}">
                            End
                        </th>
                        <th width="150px" class="text-center">Action</th>
                    </tr>
                    <tr>
                        <th class="text-center"><button type="submit" class="btn btn-light border"><i class="fas fa-search"></i></button></th>
                        <th><input type="date" name="filters[date]" class="form-control" value="{{ $filters['date'] ?? null }}"></th>
                        <th>
                            <select class="form-control form-select " name="filters[task_category_id]"  title="-- Select --">
                                <option value="">-- Select --</option>
                                @foreach(Models\task_category::select('name','id')->orderBy('name')->get() as $row)
                                    <option value="{{ $row->id }}" {{ ($filters['task_category_id'] ?? null) == $row->id? 'selected' : '' }}>{{ $row->name ?? null }}</option>
                                @endforeach
                            </select>
                        </th>
                        <th><input type="text" name="filters[jobdesk]" class="form-control" value="{{ $filters['jobdesk'] ?? null }}"></th>
                        <th>
                            <select class="form-control form-select " name="filters[task_status_id]"  title="-- Select --">
                                <option value="">-- Select --</option>
                                @foreach(Models\task_status::select('name','id')->orderBy('name')->get() as $row)
                                    <option value="{{ $row->id }}" {{ ($filters['task_status_id'] ?? null) == $row->id? 'selected' : '' }}>{{ $row->name ?? null }}</option>
                                @endforeach
                            </select>
                        </th>
                        <th></th>
                        <th><input type="text" name="filters[sla_duration]" class="form-control" value="{{ $filters['sla_duration'] ?? null }}"></th>
                        <th><input type="text" name="filters[quantity]" class="form-control" value="{{ $filters['quantity'] ?? null }}"></th>
                        <th><input type="date" name="filters[start_date]" class="form-control" value="{{ $filters['start_date'] ?? null }}"></th>
                        <th><input type="date" name="filters[end_date]" class="form-control" value="{{ $filters['end_date'] ?? null }}"></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; ?>
                        @forelse ($datas as $data)
                            <tr>
                                <td class="text-center">{{ (($datas->currentPage() - 1 ) * $datas->perPage() ) + ++$i }}.</td>
                                <td nowrap>
                                    {{dateToIndo($data->date ?? null)}}
                                    @if(($data->task_status->code ?? null) == 'ONPRO')
                                        <a href="{{ url($controller_name.'/updateFlag/'.$data->id) }}" class="ms-2 {{ $data->flag == 1? 'bg-danger text-white' : 'bg-white' }} update-flag border py-1 px-2">
                                            <i class="far fa-flag"></i>
                                        </a>
                                    @endif
                                </td>
                                <td>{{$data->task_category->name ?? null}}</td>
                                <td>{{$data->jobdesk}}</td>
                                <td>
                                    @if($data->task_status_id != 1)
                                        <a href="{{ url($controller_name.'/updateCompleted/'.$data->id) }}" class="update-status">
                                            <span class="ms-2 badge text-bg-{{ statusTask()[$data->task_status_id] ?? 'primary' }}">{{$data->task_status->name ?? null}}</span>
                                        </a>
                                    @else
                                        <span class="ms-2 badge text-bg-{{ statusTask()[$data->task_status_id] ?? 'primary' }}">{{$data->task_status->name ?? null}}</span>
                                    @endif
                                </td>
                                @if($position_code == 'SPV')
                                    <td>{{$data->employee_owner->name ?? null}}</td>
                                @else
                                    <td>{{$data->employee_pic->name ?? null}}</td>
                                @endif
                                <td>{{$data->sla_duration}}</td>
                                <td>{{$data->quantity}}</td>
                                <td nowrap>{{date('H:i', strtotime($data->start_date))}}</td>
                                <td nowrap>{{date('H:i', strtotime($data->end_date))}}</td>
                                <td class="text-center" nowrap>
                                    <!-- edit -->
                                    <a href="{{ url(strtolower($controller_name).'/edit/'.$data->id) }}" class="btn btn-primary py-1 px-2 me-1"><i class="fas fa-pen"></i></a>
                                    
                                    <!-- detail -->       
                                    <a href="{{ url(strtolower($controller_name).'/detail/'.$data->id) }}" class="btn btn-info py-1 px-2 me-1"><i class="fas fa-info-circle"></i></a>
                                    
                                    <!-- delete -->
                                    <a class="btn btn-danger delete-list py-1 px-2" data-name="{{ $data->name }}" href="{{ url($controller_name.'/delete/'.$data->id) }}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" align="center">
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
    @if(Session::get('success') == 1)
        swalSaveButtons.fire('Saved Successfully!', '', 'success')
    @endif
    $(".update-status").click(function (e) {
        e.preventDefault();

        e.stopPropagation();
        e.stopImmediatePropagation();

        var url = $(this).attr('href');

        swalSaveButtons.fire({
            title: 'Completed Job?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            reverseButtons: true
            }).then((result) => {
            if (result.isConfirmed) {
                $(this).closest("form").submit();
                window.location.href = url;
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {}
        });
    });
    $(".update-flag").click(function (e) {
        e.preventDefault();

        e.stopPropagation();
        e.stopImmediatePropagation();

        var url = $(this).attr('href');

        swalSaveButtons.fire({
            title: 'Apakah task anda terdapat kendala?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            reverseButtons: true
            }).then((result) => {
            if (result.isConfirmed) {
                $(this).closest("form").submit();
                window.location.href = url;
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {}
        });
    });
</script>