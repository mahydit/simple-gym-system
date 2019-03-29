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
<form action="{{route('gyms.store')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Gym Name</label>
            <input name="name" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Gym Name">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">City Name</label>
            <select class="form-control" name="city_id">
                @foreach($cities as $city)
                    <option value="{{$city->id}}">{{$city->name}}</option>
                @endforeach
            </select>
        </div>


        <label for="image">Upload Avatar Image</label>
            <input type="file"  id="image" name="image">


    <button type="submit" class="btn btn-primary">Submit</button>
    </form>

@endsection
@section('plugins')
 <!-- jQuery 3 -->
 <script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
@endsection