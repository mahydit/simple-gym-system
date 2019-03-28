@extends('layouts.dashboard')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('style')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
@endsection

@section('content')

<table id="coaches-table" class="table">
    <thead>
        <tr>
            <td>ID</td>
            <td>Name</td>
            <td>At Gym</td>
            <td>show</td>
            <td>edit</td>
            <td>delete</td>
        </tr>
    </thead>
    
</table>
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
                    {{ method_field('DELETE') }}
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
        $('#coaches-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('get.coach') !!}',
            columns: [
                {data: 'id'},
                {data: 'name'},
                {data: 'at_gym_id'},
                /* Show */
                {
                    mRender: function (data, type, row) {
                        return '<center><a href="/coaches/' + row.id +
                            '" class="table-delete btn btn-info" data-id="' + row.id +
                            '">Show</a></center>'
                    }
                },
                /* EDIT */
                {
                    mRender: function (data, type, row) {
                        return '<center><a href="/coaches/' + row.id +
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

            ]
        });
        $(document).on('click', '#delete_item', function () {
            var coach_id = $(this).attr('row_delete');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/coaches/' + coach_id,
                type: 'DELETE',
                success: function (data) {
                    console.log('success');
                    console.log(data);
                    var table = $('#coaches-table').DataTable();
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
