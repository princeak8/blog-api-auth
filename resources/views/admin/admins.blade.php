@extends('layouts/admin')

@section('content')
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Admins <a href="{{url('admin/admin/create')}}" class="btn btn-sm btn-primary ml-3">Add New Admin</a></h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Name</th>
            <th>Actions</th>
          </tr>
        </thead>
        @if($admins->count() > 0)
        <tbody>
        @foreach($admins as $admin)
          <tr>
            <td>{{$admin->name}}</td>
            <td>
              <a href="{{url('admin/admin/edit/'.$admin->id)}}" class="btn btn-primary">Edit</a>
              <a href="{{url('admin/admin/delete/'.$admin->id)}}" class="btn btn-danger" onclick="return confirm('Are You Sure You want to Delete this admin?')">Delete</a>
          </td>
          </tr>
          @endforeach
        </tbody>
        @endif
      </table>
      @if($admins->count()==0)
      <p>No Admin has been added at this point</p>
        @endif
    </div>
  </div>
</div>
@stop