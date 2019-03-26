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
<form action="{{route('cities.store')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">City Name</label>
            <input name="title" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Title">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">City Manager Name</label>
            <select class="form-control" name="user_id">
                @foreach($cities as $city)
                    <option value="{{$city->id}}">{{$city->cityManager->user->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Country</label>
            <select class="form-control" name="user_id">
                @foreach($cities as $city)
                    <option value="{{$city->id}}">{{$city->country->name}}</option>
                @endforeach
            </select>
        </div>

    <button type="submit" class="btn btn-primary">Submit</button>
    </form>

@endsection