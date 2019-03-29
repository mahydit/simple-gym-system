@extends('layouts.dashboard')

@section('content')
 <!-- ./col -->
 <div class="box">
    <div class="box-header with-border">
              <h3 class="box-title">{{$citymanager->name}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <dl class="dl-horizontal">
                <dt>ID</dt>
                <dd>{{$citymanager->id}}</dd>
                <dt>SID</dt>
                <dd>{{$citymanager->SID}}</dd>
                <dt>Name</dt>
                <dd>{{$citymanager->user->name}}</dd>
                <dt>Email</dt>
                <dd>{{$citymanager->user->email}}</dd>
                <dt>Password</dt>
                <dd>{{$citymanager->user->password}}</dd>
                <dt>Avatar Image</dt>
                <dd><img src="{{Storage::url($citymanager->user->profile_img)}}"></dd>
              </dl>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
@endsection
@section('plugins')
 <!-- jQuery 3 -->
 <script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
 @endsection