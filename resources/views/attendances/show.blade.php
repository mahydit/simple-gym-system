@extends('layouts.dashboard')

@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Attendance Details</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <dl class="dl-horizontal">
            <dt>Reservation Date</dt>
            <dd>{{date(' \o\n l jS F Y ', strtotime($attendance->attendance_date))}}</dd>
            <dt>Reservation Time</dt>
            <dd>{{date('h:i a', strtotime($attendance->time))}}</dd>
            <dt>Gym Name</dt>
            <dd>{{$gym->name}}</dd>
            <dt>Session Name</dt>
            <dd>{{$session->name}}</dd>
            <dt>Session Date</dt>
            <dd>{{$session->session_date}}</dd>
            <dt>Session Starts at</dt>
            <dd>{{date('h:i a', strtotime($session->starts_at))}}</dd>
            <dt>Session Ends at</dt>
            <dd>{{date('h:i a', strtotime($session->ends_at))}}</dd>
            <dt>Attendee Name</dt>
            <dd>{{$user->name}}</dd>
            <dt>Attendee Email</dt>
            <dd>{{$user->email}}</dd>
    </div>
    <!-- /.box-body -->
</div>
@endsection

@section('plugins')
<!-- jQuery 3 -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
@endsection
