@extends('layouts.dashboard')

@section('content')
<a href="{{route('cities.create')}}" class="btn btn-success">Add New City</a>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">City Name</th>
      <th scope="col">City Manager Name</th>
      <th scope="col">Country Name</th>
    </tr>
  </thead>
  <tbody>
    @foreach($cities as $city)
    <tr>
      <th scope="row">{{$city->id}}</th>
      <td>{{$city->name}}</td>
      <td>{{$city->cityManager->user->name}}</td>
      <td>{{$city->country->name}}</td>
      <td>
        <a href="{{route('cities.show', [$city->id])}}" class="btn btn-success">View</a>
        <a href="{{route('cities.edit', [$city->id])}}" class="btn btn-success">Edit</a>
        <form action="{{route('cities.destroy', [$city->id])}}" method="POST">
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