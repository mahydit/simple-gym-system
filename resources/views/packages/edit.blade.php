@extends('layouts.dashboard')

@section('style')
<!-- Bootstrap time Picker -->
<link rel="stylesheet" href="{{ asset('plugins/timepicker/bootstrap-timepicker.min.css')}}">
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">

@endsection

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
   <form action="{{ route('packages.update', [$package->id]) }}" method="POST">
        @method('PUT')
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input name="name" value="{{$package->name}}" type="text" class="form-control" id="name" aria-describedby="emailHelp" placeholder="{{$package->name}}">
        </div>
        <div class="form-group">
        <label for="exampleInputEmail1">Price</label>
        <input name="price" value="{{$package->price}}" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="{{$package->price}}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">No of Sessions</label>
            <input name="no_sessions" value="{{$package->no_sessions}}" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="{{$package->no_sessions}}">
        </div>

   <button type="submit" class="btn btn-primary">Submit</button>
   </form>

@endsection

@section('plugins')
<!-- bootstrap time picker -->
<script src="{{ asset('plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<!-- bootstrap datepicker -->
<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>


@endsection

@section('script')
<script>    
    $(function () {
        //Date picker
        $('#datepicker').datepicker({
            autoclose: true
        })
        //Timepicker
        $('.timepicker').timepicker({
            showInputs: false
        })
    })

</script>
<script src="https://datatables.yajrabox.com/js/jquery.min.js"></script>
<script src="https://datatables.yajrabox.com/js/bootstrap.min.js"></script>
<script src="https://datatables.yajrabox.com/js/jquery.dataTables.min.js"></script>
<script src="https://datatables.yajrabox.com/js/datatables.bootstrap.js"></script>


@endsection
