@extends('layouts.dashboard')

@section('content')
 <!-- ./col -->
 <div class="box">
    <div class="box-header with-border">
              <h3 class="box-title">{{$gymmanager->name}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <dl class="dl-horizontal">
                <dt>ID</dt>
                <dd>{{$gymmanager->id}}</dd>
                <dt>SID</dt>
                <dd>{{$gymmanager->SID}}</dd>
                <dt>Name</dt>
                <dd>{{$gymmanager->user->name}}</dd>
                <dt>Email</dt>
                <dd>{{$gymmanager->user->email}}</dd>
                <dt>Password</dt>
                <dd>{{$gymmanager->user->password}}</dd>
                <dt>Avatar Image</dt>
                <dd><img src="{{Storage::url($gymmanager->user->profile_img)}}"></dd>
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