<div class="col-md-12 position-relative">
    <div class="card">

        <form method="GET" action="{{ url($controller_name) }}" accept-charset="UTF-8" class="form-validation-ajax" data-target="#container">
        <input type="hidden" name="sort_field" value="{{ $sort_field }}" class="order-input">
        <input type="hidden" name="sort_type" value="{{ $sort_type }}" class="order-input">
        <div class="card-body">
            <div class="alert alert-danger rounded text-danger p-3 mb-4">
                <i class="fas fa-exclamation-circle me-2"></i> You can't delete a user who has employee data
            </div>
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
                        <th class="order-link {{ ($sort_field == 'username'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'?sort_field=username&sort_type='.($sort_field == 'username'? $sort_type : 0)+1) }}">
                            Username
                        </th>
                        <th class="order-link {{ ($sort_field == 'name'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'?sort_field=name&sort_type='.($sort_field == 'name'? $sort_type : 0)+1) }}">
                            Name
                        </th>
                        <th class="order-link {{ ($sort_field == 'group_name'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'?sort_field=group_name&sort_type='.($sort_field == 'group_name'? $sort_type : 0)+1) }}">
                            Group Name
                        </th>
                        <th class="order-link {{ ($sort_field == 'status'? 'sort-'.(orders()[$sort_type] ?? null) : null) }}" href="{{ url($controller_name.'?sort_field=status&sort_type='.($sort_field == 'status'? $sort_type : 0)+1) }}">
                            Status
                        </th>
                        <th width="150px" class="text-center">Action</th>
                    </tr>
                    <tr>
                        <th class="text-center"><button type="submit" class="btn btn-light border"><i class="fas fa-search"></i></button></th>
                        <th><input type="text" name="filters[username]" class="form-control" value="{{ $filters['username'] ?? null }}"></th>
                        <th><input type="text" name="filters[name]" class="form-control" value="{{ $filters['name'] ?? null }}"></th>
                        <th>
                            <select class="form-control form-select " name="filters[group_id]"  title="-- Select --">
                                <option value="">-- Select --</option>
                                @foreach(Models\group::select('name','id')->orderBy('name')->get() as $row)
                                    <option value="{{ $row->id }}" {{ ($filters['job_position_id'] ?? null) == $row->id? 'selected' : '' }}>{{ $row->name }}</option>
                                @endforeach
                            </select>
                        </th>
                        <th>
                            <select class="form-control form-select" name="filters[status]" title="-- Select --">
                                <option value="">-- Select --</option>
                                @foreach(status() as $key => $name)
                                    <option value="{{ $key }}" {{ ($filters['status'] ?? '') == $key? 'selected' : '' }}>{{ $name }}</option>
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
                                <td>{{$data->username}}</td>
                                <td>{{$data->name}}</td>
                                <td>{{$data->group_name}}</td>
                                <td nowrap>
                                    <span class="badge text-bg-{{ statusBg()[$data->status] ?? 'secondary' }}">
                                        {{ status()[$data->status] ?? null }}
                                    </span>
                                </td>
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