@extends('layouts.dashboard')

@section('style')
<!-- Bootstrap time Picker -->
<link rel="stylesheet" href="{{ asset('plugins/timepicker/bootstrap-timepicker.min.css')}}">
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css')}}">
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
<!-- general form elements disabled -->
<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Edit Session</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <form action="{!! route('sessions.update',['session'=>$session->id]) !!}" method="POST">
        @method('PUT')
            @csrf

            <!-- text input -->
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" value="{{$session->name}}"disabled>
            </div>

            @hasrole('admin')
             <!-- select -->
             <div class="form-group">
                <label>Select City</label>
                <select class="form-control" disabled>
                    <option selected>{{$city->name}}</option>
                </select>
            </div>
            @endhasrole

            @hasrole('citymanager')
            <!-- select -->
            <div class="form-group">
                <label>Select Gym</label>
                <select class="form-control" disabled>
                    <option selected>{{$gym->name}}</option>
                </select>
            </div>
            @endhasrole

            <!-- Date -->
            <div class="form-group">
                <label>Date:</label>

                <div class="input-group date {{ $errors->has('session_date') ? 'has-error' : '' }}">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" id="datepicker" placeholder="Session Date"
                        name="session_date"  value="{{$session->session_date}}">
                </div>
                @if ($errors->has('session_date'))
                <span class="help-block" style="color:red;" role="alert">
                    <strong>{{ $errors->first('session_date') }}</strong>
                </span>
                @endif
                <!-- /.input group -->
            </div>

            <div class="{{ $errors->has('starts_at') ? 'has-error' : '' }}">
                <div class="bootstrap-timepicker">
                    <div class="form-group col-md-6">
                        <label>Starts at:</label>

                        <div class="input-group">
                            <input type="text" class="form-control timepicker" name="starts_at" value="{{date('g:ia', strtotime($session->starts_at))}}">

                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                        </div>
                        <!-- /.input group -->
                        @if ($errors->has('starts_at'))
                            <span class="help-block col-md-6" role="alert">
                                <strong>{{ $errors->first('starts_at') }}</strong>
                            </span>
                            @endif
                    </div>
            
                </div>
            </div>

            <div class="col-md-6 {{ $errors->has('ends_at') ? 'has-error' : '' }}">
                <div class="bootstrap-timepicker">
                    <div class="form-group">
                        <label>Ends at:</label>

                        <div class="input-group">
                            <input type="text" class="form-control timepicker" name="ends_at" value="{{date('g:ia', strtotime($session->ends_at))}}">

                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                        </div>
                        @if ($errors->has('ends_at'))
                        <span class="help-block" role="alert">
                            <strong>{{ $errors->first('ends_at') }}</strong>
                        </span>
                        @endif
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->
                </div>
            </div>

            <div class="form-group">
                <div class="form-group">
                    <label>Coaches</label>
                    <select id="coaches" class="form-control select2" multiple="multiple"
                        data-placeholder="Select a coach" style="width: 100%;" disabled>
                        @foreach($coaches as $coach)
                        <option selected>{{$coach->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>



            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>

        </form>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
@endsection

@section('plugins')
<!-- jQuery 3 -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
 <!-- bootstrap time picker -->
 <script src="{{ asset('plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
 <!-- bootstrap datepicker -->
 <script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
 <!-- Select2 -->
 <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js')}}"></script>
 @endsection
 
@section('script')
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Date picker
        $('#datepicker').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        })
        //Timepicker
        $('.timepicker').timepicker({
            showInputs: false,
        })
    })

</script>
@endsection