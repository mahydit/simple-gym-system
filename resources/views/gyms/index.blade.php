@extends('layouts.dashboard')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('style')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
@endsection

@section('content')

<a href="{{route('gyms.create')}}" class="btn btn-success">Add New Gym</a>
<table id="gyms-table"class="table table-striped">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Gym Name</th>
      <th scope="col">City Name</th>
      <th scope="col">Created By</th>
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
        $('#gyms-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('get.gym') !!}',
            columns: [
                {data: 'id'},
                {data: 'name'},
                {data: 'city_id'},
                {data: 'created_by'},                
                /* Show */
                {
                    mRender: function (data, type, row) {
                        return '<center><a href="/gyms/' + row.id +
                            '" class="table-delete btn btn-info" data-id="' + row.id +
                            '">Show</a></center>'
                    }
                },
                /* EDIT */
                {
                    mRender: function (data, type, row) {
                        return '<center><a href="/gyms/' + row.id +
                            '/edit" class="table-edit btn btn-warning" data-id="' + row.id +
                            '">Edit</a></center>'
                    }
                },
                        /* DELETE */
                        {
                    mRender: function (data, type, row) {
                        return '<center><a href="{{route('gyms.index')}}" class="table-delete btn btn-danger" row_id="' +
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
            var gym_id = $(this).attr('row_delete');
            $.ajax({
                data:{
                    _method:"delete",
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/gyms/' + gym_id +'/destroy',
                type: 'post',
                success: function (data) {
                    var table = $('#gyms_table').DataTable();
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

