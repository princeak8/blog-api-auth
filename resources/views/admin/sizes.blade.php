@extends('layouts/admin')

@section('content')
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Sizes</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Size</th>
            @foreach($size_types as $type)
                <th>{{$type->type}}<th>
            @endforeach
          </tr>
        </thead>
        <tbody>
            @foreach($sizes as $size)
          <tr>
            <td>{{$size->size}}</td>
            @foreach($size->size_ranges as $range)
                <td>{{$range->min}} - {{$range->max}}</td>
                <td>
                    <a href="{{url('admin/size/edit/'.$range->id)}}" class="btn btn-primary">Edit</a>
                </td>
            @endforeach
            
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@stop