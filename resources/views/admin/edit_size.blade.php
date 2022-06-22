@extends('layouts/admin')

@section('content')

 <!-- Begin Page Content -->
 <div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-inline-flex">
                <a href="{{url('admin/sizes')}}">Sizes</a> / 
                <p class="m-0 font-weight-bold text-secondary">{{$size_range->size->size}} - {{$size_range->size_type->type}}</p>
            </div>
        </div>
        <div class="card-body">
           
                <div if="form-container">
                    {!! Form::model($size_range, ['url' => "admin/size/update?id=$size_range->id",'method' => 'post', 
                        'id'=>'sizeForm', 'class'=>'form-horizontal', ])
                    !!}
                    @include('inc.message')

                        <div class="form-group">
                            {{Form::label('Min')}}
                            {{Form::number("min", old("min"), ["class" => "form-control","placeholder"=>"Minimum","required"=>"required"]) }}
                        </div>

                        <div class="form-group">
                            {{Form::label('Max')}}
                            {{Form::number("max", old("max"), ["class" => "form-control","placeholder"=>"Maximum","required"=>"required"]) }}
                        </div>
                       
                        <div class="form-group">
                            {{ Form::submit('Save', array('class'=>'form-control  mt-4 btn btn-primary'))}}
                        </div>
                    {!! Form::close() !!} 
                </div>
            
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@stop