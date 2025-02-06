@include('component.header_pdf')

<style>
    .table tbody tr td{
        vertical-align:middle
    }
</style>

<br>
<table class="table list_content" width="100%">
    <thead>
        <tr class="ordering">
            <th width="5%">No</th>
            <th>Username</th>
            <th>Name</th>
            <th>Group Name</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @if ($datas->count() < 1)
            <tr>
                <td colspan="5" style="text-align: center">Data Tidak Ditemukan</td>
            </tr>
        @else
            <?php $i = 0;?>
            @foreach ($datas as $data)
                <tr>
                    <td class="text-center">{{ ++$i }}</td>
                    <td>{{ $data->username }}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->group_name }}</td>
                    <td>{{status()[$data->status] ?? null}}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>