@extends('layouts.dashboard')

@section('style')
<!-- Bootstrap time Picker -->
<link rel="stylesheet" href="{{ asset('plugins/timepicker/bootstrap-timepicker.min.css')}}">
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
<!-- Select2 -->
<link rel="stylesheet" href="../../bower_components/select2/dist/css/select2.min.css">
@endsection

<!-- TODO: add error msg underneath each element -->
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
        <h3 class="box-title">Create Session</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <form action="{{route('sessions.store')}}" method="POST">
            @csrf

            <!-- text input -->
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label>Name</label>
                <input type="text" class="form-control" value="{{ old('name') }}" placeholder="Session Name"
                    name="name">
                @if ($errors->has('name'))
                <span class="help-block" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
            </div>


            <!-- select -->
            <div class="form-group{{ $errors->has('gym_id') ? 'has-error' : '' }}">
                <label>Select Gym</label>
                <select class="form-control" name="gym_id" readonly>
                    <option value="{{$gym->id}}">{{$gym->name}}</option>
                </select>
                @if ($errors->has('gym_id'))
                <span class="help-block" role="alert">
                    <strong>{{ $errors->first('gym_id') }}</strong>
                </span>
                @endif
            </div>

            <!-- Date -->
            <div class="form-group">
                <label>Date:</label>

                <div class="input-group date {{ $errors->has('session_date') ? 'has-error' : '' }}">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" id="datepicker" placeholder="Session Date"
                        name="session_date"  value="{{ old('session_date') }}">
                      
                </div>
                  @if ($errors->has('session_date'))
                <span class="help-block" role="alert">
                    <strong>{{ $errors->first('session_date') }}</strong>
                </span>
                @endif
                <!-- /.input group -->
                
            </div>

            <div class="col-md-6">
                <div class="bootstrap-timepicker">
                    <div class="form-group">
                        <label>Starts at:</label>

                        <div class="input-group">
                            <input type="text" class="form-control timepicker" name="starts_at"
                                placeholder="Session Starts At">

                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                           
                        </div>
                        <!-- /.input group -->
                       
                    </div>
                    <!-- /.form group -->
                    <!-- @if ($errors->has('starts_at'))
                <span class="help-block" role="alert">
                    <strong>{{ $errors->first('starts_at') }}</strong>
                </span>
                @endif -->
                </div>
            </div>

            <div class="col-md-6">
                <div class="bootstrap-timepicker">
                    <div class="form-group">
                        <label>Ends at:</label>

                        <div class="input-group">
                            <input type="text" class="form-control timepicker" name="ends_at"
                                placeholder="Session Ends At">

                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->
                </div>
            </div>

            <div class="form-group">
                <div class="form-group">
                    <label>Coaches</label>
                    <select id="coaches" class="form-control select2" name="coach_id[]" multiple="multiple"
                        data-placeholder="Select a coach" style="width: 100%;">
                        @foreach($coaches as $coach)
                        <option value="{{$coach->id}}">{{$coach->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>



            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </form>
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
<!-- Select2 -->
<script src="../../bower_components/select2/dist/js/select2.full.min.js"></script>
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
            use24hours: true,
            timeFormat: "h:m:s",
            showInputs: false,
        })
    })

</script>
@endsection
