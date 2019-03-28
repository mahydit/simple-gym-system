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
<a href="{{route('cities.index')}}" class="btn btn-danger">Back</a>

<form action="{{route('cities.update',[$city->id])}}" method="POST">
    @csrf
    {{ method_field('PUT') }}


    <div class="form-group">
        <label for="exampleInputEmail1">City Name</label>
        <input name="title" value="{{$city->name}}" type="text" class="form-control" id="exampleInputEmail1"
            aria-describedby="emailHelp">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">City Manager Name</label>
        <select class="form-control" name="city_manager_id">
            @foreach($cities as $city)
            <option value="{{$city->id}}">{{$city->cityManager->user->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="exampleInputPassword1">Country</label>
        <select class="form-control" name="country_id">
            @foreach($countries as $country)
            <option value="{{$country->id}}">{{$country->name}}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection
@section('plugins')
 <!-- jQuery 3 -->
 <script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
@endsection