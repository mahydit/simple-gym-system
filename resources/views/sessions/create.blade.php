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


            @hasrole('admin')
            <!-- show cities select for the city -->
            <div class="form-group{{ $errors->has('city_id') ? 'has-error' : '' }}">
                <label>Select City</label>
                <select class="form-control dynamic-gym" name="city_id" id="city_id" data-dependent="gym_id">
                <option disabled selected>Select City</option>
                    @foreach($cities as $city)
                    <option value="{{$city->id}}">{{$city->name}}</option>
                    @endforeach
                </select>
                @if ($errors->has('city_id'))
                <span class="help-block" role="alert">
                    <strong>{{ $errors->first('city_id') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group {{ $errors->has('gym_id') ? 'has-error' : '' }}">
                <div class="form-group">
                    <label>Gyms</label>
                    <select class="form-control select2 dynamic-coach" name="gym_id" id="gym_id"
                        data-placeholder="Select a Gym" style="width: 100%;" data-dependent="coach_id">
                        <option disabled selected>Select Gym</option>
                    </select>
                    @if ($errors->has('gym_id'))
                    <span class="help-block" role="alert">
                        <strong>{{ $errors->first('gym_id') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            
            <div class="form-group {{ $errors->has('coach_id') ? 'has-error' : '' }}">
                <div class="form-group">
                    <label>Coaches</label>
                    <select class="form-control select2" name="coach_id[]" id="coach_id" multiple="multiple"
                        data-placeholder="Select a coach" style="width: 100%;">
                        <option disabled selected>Select Coach</option>
                    </select>
                    @if ($errors->has('coach_id'))
                    <span class="help-block" role="alert">
                        <strong>{{ $errors->first('coach_id') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            @endhasrole


            @hasrole('citymanager')
            <!-- Show city select readonly -->
            <div class="form-group{{ $errors->has('city_id') ? 'has-error' : '' }}">
                <label>Select Ciy</label>
                <select class="form-control" name="city_id" readonly>
                    <option value="{{$city->id}}">{{$city->name}}</option>
                </select>
                @if ($errors->has('city_id'))
                <span class="help-block" role="alert">
                    <strong>{{ $errors->first('city_id') }}</strong>
                </span>
                @endif
            </div>

            <!-- show gyms select for the city -->
            <div class="form-group{{ $errors->has('gym_id') ? 'has-error' : '' }}">
                <label>Select Gym</label>
                <select class="form-control dynamic-coach" name="gym_id" id="gym_id" data-dependent="coach_id">
                    @foreach($gyms as $gym)
                    <option value="{{$gym->id}}">{{$gym->name}}</option>
                    @endforeach
                </select>
                @if ($errors->has('gym_id'))
                <span class="help-block" role="alert">
                    <strong>{{ $errors->first('gym_id') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group {{ $errors->has('coach_id') ? 'has-error' : '' }}">
                <div class="form-group">
                    <label>Coaches</label>
                    <select class="form-control select2" name="coach_id[]" id="coach_id" multiple="multiple"
                        data-placeholder="Select a coach" style="width: 100%;">
                        <option disabled selected>Select Coach</option>
                    </select>
                    @if ($errors->has('coach_id'))
                    <span class="help-block" role="alert">
                        <strong>{{ $errors->first('coach_id') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            @endhasrole


            @hasrole('gymmanager')
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

            <div class="form-group {{ $errors->has('coach_id') ? 'has-error' : '' }}">
                <div class="form-group">
                    <label>Coaches</label>
                    <select id="coaches" class="form-control select2" name="coach_id[]" multiple="multiple"
                        data-placeholder="Select a coach" style="width: 100%;">
                        @foreach($coaches as $coach)
                        <option value="{{$coach->id}}">{{$coach->name}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('coach_id'))
                    <span class="help-block" role="alert">
                        <strong>{{ $errors->first('coach_id') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            @endhasrole

            <!-- Date -->
            <div class="form-group">
                <label>Date</label>
                <div class="input-group date {{ $errors->has('session_date') ? 'has-error' : '' }}">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" id="datepicker" placeholder="Session Date"
                        name="session_date" value="{{ old('session_date') }}">

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
                        <label>Starts at</label>

                        <div class="input-group">
                            <input type="text" class="form-control timepicker" name="starts_at"
                                placeholder="Session Starts At">

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
                        <label>Ends at</label>

                        <div class="input-group">
                            <input type="text" class="form-control timepicker" name="ends_at"
                                placeholder="Session Ends At">

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
            <br>

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
 <!-- jQuery 3 -->
 <script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
 <script src="//code.jquery.com/jquery.js"></script>
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
            // use24hours: true,
            // timeFormat: "h:m:s",
            // showMeridian:false,
            showInputs: false,
        })
    })

</script>
@hasrole('citymanager')
<script>
    $(document).ready(function() {
        $('.dynamic-coach').change(function () {
            if ($(this).val() != '') {
                var select = $(this).attr("id");
                var value = $(this).val();
                var dependent = $(this).data('dependent');
                var _token = $('input[name="_token"]').val();
                console.log(value);
                $.ajax({
                    url: "{{ route('dynamicdependent.fetchCoaches') }}",
                    method: "POST",
                    data: {select: select, value: value, _token: _token, dependent: dependent},
                    success: function (result) {
                        console.log(result);
                        $('#' + dependent).html(result);
                        console.log(select,value,dependent);
                    },
                    error: function (respose) {
                        alert(' error');
                        console.log(select,value,dependent);
                        console.log(respose);
                    }
                })
            }
        });
        $('#gym_id').change(function(){
            $('#coach_id').val('');
        });
        
    });
</script>
@endhasrole

@hasrole('admin')
<script>
    $(document).ready(function() {
        $('.dynamic-gym').change(function () {
            if ($(this).val() != '') {
                var select = $(this).attr("id");
                var value = $(this).val();
                var dependent = $(this).data('dependent');
                var _token = $('input[name="_token"]').val();
                console.log(value);
                $.ajax({
                    url: "{{ route('dynamicdependent.fetchGyms') }}",
                    method: "POST",
                    data: {select: select, value: value, _token: _token, dependent: dependent},
                    success: function (result) {
                        console.log(result);
                        $('#' + dependent).html(result);
                        console.log(select,value,dependent);
                    },
                    error: function (respose) {
                        alert(' error');
                        console.log(select,value,dependent);
                        console.log(respose);
                    }
                })
            }
        });
        $('.dynamic-coach').change(function () {
            if ($(this).val() != '') {
                var select = $(this).attr("id");
                var value = $(this).val();
                var dependent = $(this).data('dependent');
                var _token = $('input[name="_token"]').val();
                console.log(value);
                $.ajax({
                    url: "{{ route('dynamicdependent.fetchCoaches') }}",
                    method: "POST",
                    data: {select: select, value: value, _token: _token, dependent: dependent},
                    success: function (result) {
                        console.log(result);
                        $('#' + dependent).html(result);
                        console.log(select,value,dependent);
                    },
                    error: function (respose) {
                        alert(' error');
                        console.log(select,value,dependent);
                        console.log(respose);
                    }
                })
            }
        });
        $('#gym_id').change(function(){
            $('#coach_id'). val('');
        });
    });
</script>
@endhasrole

@endsection
