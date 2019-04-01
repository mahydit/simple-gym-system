@extends('layouts.dashboard')

@section('content')
<div class="content box">
<h1>Welcome, {{Auth::user()->name}}!</h1>
</div>
@endsection
@section('plugins')
 <!-- jQuery 3 -->
 <script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
@endsection
