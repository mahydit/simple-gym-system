@extends('layouts.dashboard')

@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Purchase Details</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
    <dl class="dl-horizontal">
                <dt>Purchase Made</dt>
                <dd>{{date(' \o\n l jS F Y ', strtotime($purchase->purchase_date))}}</dd>
                <dt>Purchase Price</dt>
                <dd>{{$purchase->price}}</dd>
                <dt>Gym</dt>
                <dd>{{$gym->name}}</dd>
                <dt>Attendee Name</dt>
                <dd>{{$attendee->name}}</dd>
                <dt>Attendee Email</dt>
                <dd>{{$attendee->email}}</dd>
    </div>
    <!-- /.box-body -->

</div>
@endsection
@section('plugins')
 <!-- jQuery 3 -->
 <script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
 @endsection
