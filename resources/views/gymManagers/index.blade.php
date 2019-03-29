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
                <p class="box-title">Gym Managers</p>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="gym_managers_table" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Password</th>
                            <th class="text-center">National ID</th>
                            <th class="text-center">Avatar Image</th>
                            <th class="text-center">Ban</th>
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
                <h3 class="modal-title" id="exampleModalLabel">Are you sure you want to delete this Gym Manager</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <div>
                    <div id="csrf_value" hidden>@csrf</div>
                    {{ method_field('DELETE') }}
                    <button type="button" row_delete="" id="delete_item" class="btn btn-danger"
                        data-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="banpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Are you sure you want to Ban this Gym Manager</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <div>
                    <div id="csrf_value" hidden>@csrf</div>
                    {{ method_field('PUT') }}
                    <button type="button" row_ban="" id="ban_item" class="btn btn-danger"
                        data-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="unbanpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Are you sure you want to UnBan this Gym Manager</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <div>
                    <div id="csrf_value" hidden>@csrf</div>
                    {{ method_field('PUT') }}
                    <button type="button" row_unban="" id="unban_item" class="btn btn-danger"
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
        $('#gym_managers_table').DataTable({
            processing: true,
            serverSide: true,
            'paging': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': true,
            "bLengthChange": true,
            'autoWidth': true,

            ajax: '{!! route('get.gym_manager') !!}',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'user.email',
                    name: 'user.email'
                },
                {
                    data: 'user.name',
                    name: 'user.name'
                },
                {
                    data: 'user.password',
                    name: 'user.password'
                },
                {
                    data: 'SID',
                    name: 'SID'
                },
                {
                    data: 'profile_image',
                    name: 'profile_image',

                },
                /* Ban And Unban*/
                {
                    mRender: function (data, type, row) {
                        if(row.banned_at === null){
                            return '<center><a href="#" class="table-delete btn btn-danger" row_id="' +
                            row.id +
                            '" data-toggle="modal" data-target="#banpopup" id="ban_toggle">Ban</a></center>'
                        }
                        else{
                            return '<center><a href="#" class="table-delete btn btn-success" row_id="' +
                            row.id +
                            '" data-toggle="modal" data-target="#unbanpopup" id="unban_toggle">Unban</a></center>'
                        }

                    }
                },
                /* Show */
                {
                    mRender: function (data, type, row) {
                        return '<center><a href="/gymManagers/' + row.id +
                            '" class="table-delete btn btn-info" data-id="' + row.id +
                            '">Show</a></center>'
                    }
                },
                /* EDIT */
                {
                    mRender: function (data, type, row) {
                        return '<center><a href="/gymManagers/' + row.id +
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
            var gym_manager_id = $(this).attr('row_delete');
            $.ajax({
                data:{
                    _method:"delete",
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/gymManagers/' + gym_manager_id,
                type: 'post',
                success: function (data) {
                    var table = $('#gym_managers_table').DataTable();
                    table.ajax.reload();
                },
                error: function (response) {
                    alert(' error');

                }
            });
        });
        $(document).on('click', '#ban_toggle', function () {
            var ban_id = $(this).attr('row_id');
            $('#ban_item').attr('row_ban', ban_id);
        });
        $(document).on('click', '#ban_item', function () {
            var gym_manager_id = $(this).attr('row_ban');
            $.ajax({
                data:{
                    _method:"put",
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/gymManagers/' + gym_manager_id + "/ban",
                type: 'post',
                success: function (data) {
                    var table = $('#gym_managers_table').DataTable();
                    table.ajax.reload();
                },
                error: function (response) {
                    alert(' error');
                }
            });
        });


        $(document).on('click', '#unban_toggle', function () {
            var unban_id = $(this).attr('row_id');
            $('#unban_item').attr('row_unban', unban_id);
        });
        $(document).on('click', '#unban_item', function () {
            var gym_manager_id = $(this).attr('row_unban');
            $.ajax({
                data:{
                    _method:"put",
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/gymManagers/' + gym_manager_id + "/unban",
                type: 'post',
                success: function (data) {
                    var table = $('#gym_managers_table').DataTable();
                    table.ajax.reload();
                },
                error: function (response) {
                    alert(' error');
                }
            });
        });

    });

</script>
@endsection

