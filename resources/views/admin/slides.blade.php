@extends('layouts/admin')

@section('content')
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Slides 
        @if($slides->count() < 6)
            <a href="{{url('admin/slide/create')}}" class="btn btn-sm btn-primary ml-3">Add New Slide</a></h6>
        @endif
  </div>
  <div class="card-body">
        @if($slides->count() > 0)
          <div id="slides" class="row">
            @foreach($slides as $slide)
              <div class="col-4">
                <img src="{{ asset('uploads/slides/'.$slide->name) }}" alt="" title="" style="width:100%; height:15em;" />
                @if($slides->count() > 1)
                    {!! Form::open(['url' => "admin/slide/delete",'method' => 'post' ]) !!}
                        <input type="hidden" name="id" value="{{$slide->id}}" />
                        <input type="submit" value="Delete" class="btn btn-danger" onclick="return confirm('Are You Sure You want to Delete this photo?')" />
                    {!! Form::close() !!} 
                @endif
              </div>
            @endforeach
          </div>
        @else
          <p>No Slide has been added</p>
        @endif
  </div>
</div>
@stop