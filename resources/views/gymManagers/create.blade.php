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
<a href="{{route('gymManagers.index')}}" class="btn btn-danger">Back</a>
<form action="{{route('gymManagers.store')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Gym Manager Name</label>
            <input name="name" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Gym Manager Name">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Gym Manager Email</label>
            <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Gym Manager Email">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Gym Manager Password</label>
            <input name="password" type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Gym Manager Password">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Gym Manager SID</label>
            <input name="sid" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Gym Manager National ID">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Gym Name</label>
            <select class="form-control" name="user_id">
                @foreach($gyms as $gym)
                    <option value="{{$gym->id}}">{{$gym->name}}</option>
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