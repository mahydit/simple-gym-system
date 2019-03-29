@extends('layouts.dashboard')

@section('style')
<!-- Bootstrap time Picker -->
<link rel="stylesheet" href="{{ asset('plugins/timepicker/bootstrap-timepicker.min.css')}}">
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">

@endsection

@section('content')
<div class="box">
    <div class="box-header with-border">
              <h3 class="box-title">{{$package->name}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <dl class="dl-horizontal">
                <dt>Package ID</dt>
                <dd>{{$package['id']}}</dd>

                <dt>Package Name</dt>
                <dd>{{$package['name']}}</dd>

                <dt>Package Price</dt>
                <dd>{{$package['price']}}</dd>
                
                <dt>Number of Sessions</dt>
                <dd>{{$package['no_sessions']}}</dd>
              </dl>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
@endsection

@section('plugins')
<!-- bootstrap time picker -->
<script src="{{ asset('plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<!-- bootstrap datepicker -->
<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<!-- jQuery 3 -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}}"></script>


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
