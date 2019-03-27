@extends('layouts.dashboard')

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
<a href="{{route('gyms.index')}}" class="btn btn-danger">Back</a>

<form action="{{route('gyms.update',[$gym->id])}}" method="POST">
    @csrf
    {{ method_field('PUT') }}

    <div class="form-group">
        <label for="exampleInputEmail1">Gym Name</label>
        <input name="gym_name" value="{{$gym->name}}" type="text" class="form-control" id="exampleInputEmail1"
            aria-describedby="emailHelp">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">City Name</label>
        <select class="form-control" name="city_id">
            @foreach($cities as $city)
            <option value="{{$city->id}}">{{$city->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="exampleInputPassword1">Image</label>
        <button type="button" class="btn btn-light">Upload Image</button>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection
@section('plugins')
<!-- jQuery 3 -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
@endsection
