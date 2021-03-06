@extends('layouts.dashboard')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('style')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
                <p class="box-title">Sessions </p>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="session_table" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Name</th>
                            @hasanyrole('admin|citymanager')
                            <th class="text-center">Gym</th>
                            @endhasanyrole
                            <th class="text-center">Coach</th>
                            <th class="text-center">starts at</th>
                            <th class="text-center">Ends at</th>
                            <th class="text-center">Date</th>
                            @hasrole('admin')
                            <th class="text-center">City</th>
                            @endhasrole
                            <th class="text-center">Show</th>
                            <th class="text-center">Edit</th>
                            <th class="text-center">Delete</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deletepopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Are you sure you want to delete this Package</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <div>
                    <div id="csrf_value" hidden>@csrf</div>
                    @method('DELETE')
                    <button type="button" row_delete="" id="delete_item" class="btn btn-danger"
                        data-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('plugins')

<script src="//code.jquery.com/jquery.js"></script>
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
@endsection

@section('script')
<script>
    $(function () {
        $('#session_table').DataTable({
            processing: true,
            serverSide: true,
            'paging': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': true,
            "bLengthChange": true,
            'autoWidth': true,

            ajax: '{!! route('get.session') !!}',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                @hasanyrole('admin|citymanager')
                {
                    data: 'gym.name',
                    name: 'gym.name'
                },
                @endhasanyrole
                {
                    data: 'coaches[].name',
                    name: 'coaches[].name'
                },
                {
                    data: 'starts_at',
                    name: 'starts_at'
                },
                {
                    data: 'ends_at',
                    name: 'ends_at'
                },
                {
                    data: 'session_date',
                    name: 'session_date'
                },
                @hasrole('admin')
                {
                    data: 'city_name',
                    name: 'city_name'
                },
                @endhasrole

                /* SHOW */
                {
                    mRender: function (data, type, row) {
                        return '<center><a href="/sessions/' + row.id +
                            '" class="table-delete btn btn-info" data-id="' + row.id +
                            '">Show</a></center>'
                    }
                },
                /* EDIT */
                {
                    mRender: function (data, type, row) {
                        return '<center><a href="/sessions/' + row.id +
                            '/edit" class="table-edit btn btn-warning" data-id="' + row.id +
                            '">Edit</a></center>'
                    }
                },
                /* DELETE */
                {
                    mRender: function (data, type, row) {
                        return '<center><a href="#" class="table-delete btn btn-danger" row_id="' +
                            row.id +
                            '" data-toggle="modal" data-target="#deletepopup" id="delete_toggle">Delete</a></center>'
                    }
                },

            ],
        });
        $(document).on('click', '#delete_toggle', function () {
            var delete_id = $(this).attr('row_id');
            $('#delete_item').attr('row_delete', delete_id);
        });

        $(document).on('click', '#delete_item', function () {
            var session_id = $(this).attr('row_delete');
            $.ajax({
                data:{
                    _method:"delete",
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/sessions/' + session_id,
                type: 'POST',
                success: function (data) {
                    console.log('success');
                    console.log(data);
                    var table = $('#session_table').DataTable();
                    table.ajax.reload();
                },
                error: function (response) {
                    alert(' error');
                    console.log(response);
                }
            });
        });

    });

</script>
@endsection

