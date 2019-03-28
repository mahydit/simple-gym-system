@extends('layouts.dashboard')

@section('content')
<a href="{{route('gyms.create')}}" class="btn btn-success">Add New Gym</a>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Gym Name</th>
      <th scope="col">City Name</th>
      <th scope="col">Created At</th>
      <th scope="col">Updated At</th>
      <th scope="col">Created By</th>
      <th scope="col">Image</th>
    </tr>
  </thead>
  <tbody>
    @foreach($gyms as $gym)
    <tr>
      <th scope="row">{{$gym->id}}</th>
      <td>{{$gym->name}}</td>
      <td>{{$gym->cities->name}}</td>
      <td>{{date('d-m-Y H:m:s', strtotime($gym->created_at))}}</td>
      <td>{{date('d-m-Y H:m:s', strtotime($gym->updated_at))}}</td>
      <td>{{$gym->created_by}}</td>
      <td>{{$gym->image}}</td>

      <td>
        <a href="{{route('gyms.show', [$gym->id])}}" class="btn btn-success">View</a>
        <a href="{{route('gyms.edit', [$gym->id])}}" class="btn btn-success">Edit</a>
        <form action="{{route('gyms.destroy', [$gym->id])}}" method="POST">
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