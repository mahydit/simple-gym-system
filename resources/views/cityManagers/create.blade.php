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
        <h3 class="box-title">Create City Manager</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <form action="{{route('cityManagers.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- National ID input -->
            <div class="form-group {{ $errors->has('SID') ? 'has-error' : '' }}">
                <label>National ID</label>
                <input type="number" class="form-control" value="{{ old('SID') }}" placeholder="National ID"
                    name="SID">
                @if ($errors->has('SID'))
                <span class="help-block" role="alert">
                    <strong>{{ $errors->first('SID') }}</strong>
                </span>
                @endif
            </div>
            
            <!-- Email input -->
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label>Email</label>
                <input type="email" class="form-control" value="{{ old('email') }}" placeholder="Email"
                    name="email">
                @if ($errors->has('email'))
                <span class="help-block" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>       
            
            <!-- name input -->
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label>Name</label>
                <input type="text" class="form-control" value="{{ old('name') }}" placeholder="Name"
                    name="name">
                @if ($errors->has('name'))
                <span class="help-block" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
            </div>



            
            
            
            <!-- Password input -->
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <label>Password</label>
                <input type="password" class="form-control" value="{{ old('password') }}" placeholder="Password"
                    name="password">
                @if ($errors->has('password'))
                <span class="help-block" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>   
            
            
            <!-- Confirm Password input -->
            <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                <label>Confirm Password</label>
                <input type="password" class="form-control" value="{{ old('password_confirmation') }}" placeholder="Confirm Password"
                    name="password_confirmation">
                @if ($errors->has('password_confirmation'))
                <span class="help-block" role="alert">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
                @endif
            </div>   


            <!-- Upload Image input -->
            <div class="form-group {{ $errors->has('profile_img') ? 'has-error' : '' }}">

                <label for="profile_img">Upload Avatar Image</label>
                  <input type="file"  id="profile_img" name="profile_img">
                @if ($errors->has('profile_img'))
                <span class="help-block" role="alert">
                    <strong>{{ $errors->first('profile_img') }}</strong>
                </span>
                @endif
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
 <!-- jQuery 3 -->
 <script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- bootstrap time picker -->
<script src="{{ asset('plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<!-- bootstrap datepicker -->
<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<!-- Select2 -->
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js')}}"></script>
@endsection

