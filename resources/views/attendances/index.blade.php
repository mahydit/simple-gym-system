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
                <p class="box-title">Sessions Attendance</p>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="session_table" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">User Name</th>
                            <th class="text-center">Session Name</th>
                            <th class="text-center">Session starts at</th>
                            <th class="text-center">Session ends at</th>
                            <th class="text-center">Session Date</th>
                            @hasanyrole('admin|citymanager')
                            <th class="text-center">Gym Name</th>
                            @endhasanyrole
                            @hasanyrole('admin')
                            <th class="text-center">City Name</th>
                            @endhasanyrole
                            <th> show <th>
                        </tr>
                    </thead>
                </table>
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

            ajax: '{!! route('get.attendance') !!}',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'user.name',
                    name: 'user.name'
                },
                {
                    data: 'session.name',
                    name: 'session.name'
                },
                {
                    data: 'session.starts_at',
                    name: 'session.starts_at'
                },
                {
                    data: 'session.ends_at',
                    name: 'session.ends_at'
                },
                {
                    data: 'session.session_date',
                    name: 'session.session_date'
                },
                @hasanyrole('admin|citymanager')
                {
                    data: 'gym_name',
                    name: 'gym_name'
                },
                @endhasanyrole
                @hasanyrole('admin')
                {
                    data: 'city.name',
                    name: 'city.name'
                },
                @endhasanyrole
                /* Show */
                {
                    mRender: function (data, type, row) {
                        return '<center><a href="/attendances/' + row.id +
                            '" class="table-delete btn btn-info" data-id="' + row.id +
                            '">Show</a></center>'
                    }
                },

            ],
        });
    });

</script>
@endsection

