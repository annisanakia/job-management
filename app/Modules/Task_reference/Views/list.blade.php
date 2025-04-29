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
                        <th class="order-link {{ ($sort_field == 'jobdesk'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'?sort_field=jobdesk&sort_type='.($sort_field == 'jobdesk'? $sort_type : 0)+1) }}">
                            Jobdesk
                        </th>
                        <th class="order-link {{ ($sort_field == 'task_category_id'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'?sort_field=task_category_id&sort_type='.($sort_field == 'task_category_id'? $sort_type : 0)+1) }}">
                            Category
                        </th>
                        <th class="order-link {{ ($sort_field == 'job_type_id'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'?sort_field=job_type_id&sort_type='.($sort_field == 'job_type_id'? $sort_type : 0)+1) }}">
                            Job Type
                        </th>
                        <th class="order-link {{ ($sort_field == 'sla_duration'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'?sort_field=sla_duration&sort_type='.($sort_field == 'sla_duration'? $sort_type : 0)+1) }}">
                            Sla Duration
                        </th>
                        <th width="150px" class="text-center">Action</th>
                    </tr>
                    <tr>
                        <th class="text-center"><button type="submit" class="btn btn-light border"><i class="fas fa-search"></i></button></th>
                        <th><input type="text" name="filters[jobdesk]" class="form-control" value="{{ $filters['jobdesk'] ?? null }}"></th>
                        <th>
                            <select class="form-control form-select " name="filters[task_category_id]"  title="-- Select --">
                                <option value="">-- Select --</option>
                                @foreach(Models\task_category::select('name','id')->orderBy('name')->get() as $row)
                                    <option value="{{ $row->id }}" {{ ($filters['task_category_id'] ?? null) == $row->id? 'selected' : '' }}>{{ $row->name ?? null }}</option>
                                @endforeach
                            </select>
                        </th>
                        <th>
                            <select class="form-control form-select " name="filters[job_type_id]"  title="-- Select --">
                                <option value="">-- Select --</option>
                                @foreach(Models\job_type::select('name','id')->orderBy('name')->get() as $row)
                                    <option value="{{ $row->id }}" {{ ($filters['job_type_id'] ?? null) == $row->id? 'selected' : '' }}>{{ $row->name ?? null }}</option>
                                @endforeach
                            </select>
                        </th>
                        <th><input type="text" name="filters[sla_duration]" class="form-control" value="{{ $filters['sla_duration'] ?? null }}"></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; ?>
                        @forelse ($datas as $data)
                            <tr>
                                <td class="text-center">{{ (($datas->currentPage() - 1 ) * $datas->perPage() ) + ++$i }}.</td>
                                <td>{{$data->jobdesk}}</td>
                                <td>{{$data->task_category->name}}</td>
                                <td>{{$data->job_type->name}}</td>
                                <td>{{$data->sla_duration}}</td>
                                <td class="text-center" nowrap>
                                    <!-- edit -->
                                    <a href="{{ url(strtolower($controller_name).'/edit/'.$data->id) }}" class="btn btn-primary py-1 px-2 me-1"><i class="fas fa-pen"></i></a>
                                    
                                    <!-- delete -->
                                    <a class="btn btn-danger delete-list py-1 px-2" data-name="{{ $data->name }}" href="{{ url($controller_name.'/delete/'.$data->id) }}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
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