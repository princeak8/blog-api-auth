@extends('layouts/admin')

@section('content')
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Collections <a href="{{url('admin/collection/create')}}" class="btn btn-sm btn-primary ml-3">Add New Collection</a></h6>
  </div>
  <div class="card-body">
  @include('inc.message')
        @if($collections->count() > 0)
          <div id="collections" class="row">
            @foreach($collections as $collection)
              <div class="col-4">
                @if($collection->photo)
                    <img src="{{ $collection->photo->file->url }}" alt="" title="" style="width:100%; height:15em;" />
                @else
                    <img src="{{ asset('uploads/collections/thumbnails/no_pic.png') }}" alt="" title="" style="width:100%; height:15em;" />
                @endif
                <span>{{$collection->name}}</span><br/>
                <a href="{{url('admin/collection/'.$collection->id)}}" class="btn btn-primary">View</a>
                <a href="{{url('admin/collection/edit/'.$collection->id)}}" class="btn btn-warning">Edit</a>
                <a href="{{url('admin/collection/delete/'.$collection->id)}}" class="btn btn-danger" onclick="return confirm('Are You Sure You want to Delete this collection?')">Delete</a>
              </div>
            @endforeach
                            
          </div>
        @else
          <p>No Collection has been added at this point</p>
        @endif
  </div>
</div>
@stop