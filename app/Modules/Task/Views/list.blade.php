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
                        <th class="order-link {{ ($sort_field == 'task_segment_id'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'?sort_field=task_segment_id&sort_type='.($sort_field == 'task_segment_id'? $sort_type : 0)+1) }}">
                            Segment
                        </th>
                        <th class="order-link {{ ($sort_field == 'task_category_id'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'?sort_field=task_category_id&sort_type='.($sort_field == 'task_category_id'? $sort_type : 0)+1) }}">
                            Category
                        </th>
                        <th class="order-link {{ ($sort_field == 'detail'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'?sort_field=detail&sort_type='.($sort_field == 'detail'? $sort_type : 0)+1) }}">
                            Detail
                        </th>
                        <th class="order-link {{ ($sort_field == 'task_status_id'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'?sort_field=task_status_id&sort_type='.($sort_field == 'task_status_id'? $sort_type : 0)+1) }}">
                            Last Status
                        </th>
                        <th class="order-link {{ ($sort_field == 'pic'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'?sort_field=pic&sort_type='.($sort_field == 'pic'? $sort_type : 0)+1) }}">
                            PIC
                        </th>
                        <th width="150px" class="text-center">Action</th>
                    </tr>
                    <tr>
                        <th class="text-center"><button type="submit" class="btn btn-light border"><i class="fas fa-search"></i></button></th>
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
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; ?>
                        @forelse ($datas as $data)
                            <tr>
                                <td class="text-center">{{ (($datas->currentPage() - 1 ) * $datas->perPage() ) + ++$i }}.</td>
                                <td>{{$data->task_segment->name ?? null}}</td>
                                <td>{{$data->task_category->name ?? null}}</td>
                                <td>{{$data->detail}}</td>
                                <td>{{$data->task_status->name ?? null}}</td>
                                <td>{{$data->user_pic->name ?? null}}</td>
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
                                <td colspan="7" align="center">
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