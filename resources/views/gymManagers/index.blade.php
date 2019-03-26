@extends('layouts.dashboard')

@section('content')
<a href="{{route('cityManagers.create')}}" class="btn btn-success">Add New Gym Manager</a>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Gym Manager Name</th>
      <th scope="col">Managed Gym Name</th>
    </tr>
  </thead>
  <tbody>
    @foreach($gymManagers as $gymManager)
    <tr>
      <th scope="row">{{$gymManager->id}}</th>
      <td>{{$gymManager->user->name}}</td>
      @foreach($gyms as $gym)
        <td>{{$gym->name}}</td>
      @endforeach
      <td>
        <a href="{{route('gymManagers.show', [$gymManager->id])}}" class="btn btn-success">View</a>
        <a href="{{route('gymManagers.edit', [$gymManager->id])}}" class="btn btn-success">Edit</a>
        <form action="{{route('gymManagers.destroy', [$gymManager->id])}}" method="POST">
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