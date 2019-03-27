@extends('layouts.dashboard')

@section('content')
<a href="{{route('cityManagers.create')}}" class="btn btn-success">Add New City Manager</a>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">City Manager Name</th>
      <th scope="col">Managed City Name</th>
    </tr>
  </thead>
  <tbody>
    @foreach($cityManagers as $cityManager)
    <tr>
      <th scope="row">{{$cityManager->id}}</th>
      <td>{{$cityManager->user->name}}</td>
      @foreach($cities as $city)
        <td>{{$city->name}}</td>
      @endforeach
      <td>
        <a href="{{route('cityManagers.show', [$cityManager->id])}}" class="btn btn-success">View</a>
        <a href="{{route('cityManagers.edit', [$cityManager->id])}}" class="btn btn-success">Edit</a>
        <form action="{{route('cityManagers.destroy', [$cityManager->id])}}" method="POST">
          @csrf
          @method('delete')
          <button class="btn btn-danger" onclick="return confirm('Are you sure?')"> Delete </button>
        </form>
      </td>
    </tr>
    @endforeach

  </tbody>
</table>
@endsection
@section('plugins')
 <!-- jQuery 3 -->
 <script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
@endsection