@extends('layouts.dashboard')

@section('content')
<a href="{{route('gyms.index')}}" class="btn btn-danger">Back</a>

    @csrf
    <div class="card">
        <div class="card-header">
            Gym Info
        </div>
        <div class="card-body">
            <h5 class="card-title">Gym Name</h5>
            <p class="card-text"> {{$gym->name}} </p>

            <h5 class="card-title">Image</h5>
            <img src="{{Storage::url($gym->image)}}">

            <h5 class="card-title">City</h5>
            <p class="card-text"> {{$gym->city_id}} </p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Gym Creation Info
        </div>
        <div class="card-body">
            <h5 class="card-title">Creator Name</h5>
            <p class="card-text">{{$gym->created_by}} </p>

            <h5 class="card-title">Created at</h5>
            <p class="card-text">{{date('l jS \of F, Y, g:i:s A', strtotime($gym->created_at))}} </p>

        </div>
    </div>

@endsection
@section('plugins')
 <!-- jQuery 3 -->
 <script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
@endsection