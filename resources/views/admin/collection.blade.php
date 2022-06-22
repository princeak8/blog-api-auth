@extends('layouts/admin')

@section('css')
    <style type="text/css">
        .title{
            font-weight: bold;
            font-size: 1em;
        }
    </style>
@stop
@section('content')

 <!-- Begin Page Content -->
 <div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-inline-flex">
                <a href="{{url('admin/collections')}}">Collections</a> / 
                <p class="m-0 font-weight-bold text-secondary">{{$collection->name}}<a href="{{url('admin/collection/edit/'.$collection->id)}}" class="btn btn-sm btn-warning ml-3">Edit</a></p>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-8">
                    <img id="photo-{{$collection->id}}" src="{{ asset('uploads/collections/'.$collection->photo) }}" alt="" title="" style="width:100%; height:30em;" />
                    @if($collection->name!='New Arrivals')
                        <button type="button" id="change-photo" data-open="0" class="btn btn-sm btn-primary ml-3">Change Collection Cover Photo</button>
                        <div id="collection-photo" class="d-none form-group">
                            <span style="color:red">(Must be minimum width and height of 800px and 500px respectively)</span>
                            {!! Form::model($collection, ['url' => "admin/collection/photo/save?id=$collection->id",'method' => 'post', 'files' => true, 
                                'id'=>'photoForm', 'class'=>'form-horizontal'])
                            !!}
                                @include('inc.message')
                                <p id="photo-error" class="alert alert-danger d-none"></p>
                                <div><img src="" id="collection-image" /></div>
                                <input type="file" class="form-control input-file" data-id="collection-image" name="photo" accept="image/*" required />
                                <input type="hidden" name="edit" value="0" />
                                <div class="row">
                                    {{ Form::submit('Change', array('class'=>'form-control  mt-4 btn btn-primary'))}}
                                </div>
                            {!! Form::close() !!} 
                        </div>
                    @endif
                </div>
                <div class="col-4">
                    <div class="mt-4">
                        <h3><b>Description: </b></h3>
                        <p>{{$collection->description}}</p>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <h4 class="col-12 mb-2">{{$collection->name}} Products</h4>
                @if($collection->products->count() > 0)
                    <div class="row">
                        @foreach($collection->products as $product)
                            <div class="col-3">
                                <img src="{{ asset('uploads/products/thumbnails/'.$product->main) }}" alt="" title="" style="height:12em; width:100%" />
                                <div class="text-center">
                                    <span>{{$product->name}}</span>
                                    <a href="{{url('admin/product/thumbnails/'.$product->id)}}" class="btn btn-primary btn-sm px-1 py-1">View</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="row col-12 mt-4">No Products has been added at this collection</p>
                @endif
            </div>
                
        </div>
    </div>
    <input type="hidden" name="collection_id" value="{{$collection->id}}" />
</div>
<!-- /.container-fluid -->
@stop
@section('js')
    <script type="application/javascript">
        $(document).ready(function() {
            $('#change-photo').click(function() {
                $('#collection-photo').removeClass('d-none');
                var open = $(this).data('open');
                if(open==0) {
                    console.log('open');
                    $('#collection-photo').removeClass('d-none');
                    $('#collection-photo').addClass('d-block');
                    $(this).data('open', '1');
                    $(this).html('close');
                    $(this).removeClass('btn-primary');
                    $(this).addClass('btn-danger');
                }else{
                    $('#collection-photo').removeClass('d-block');
                    $('#collection-photo').addClass('d-none');
                    $(this).data('open', '0');
                    $(this).html('Change Collection Cover Photo');
                    $(this).removeClass('btn-danger');
                    $(this).addClass('btn-primary');
                }
            })
        })
        
        $(document).on('change', '.input-file', function(e) {
            var photo = e.target.files;
            var id = $(this).data('id');
            var reader = new FileReader();
            var self = $(this);
            //Read the contents of Image File.
            reader.readAsDataURL(this.files[0]);
            reader.onload = function (e) {
                //Initiate the JavaScript Image object.
                var image = new Image();
                //Set the Base64 string return from FileReader as source.
                image.src = e.target.result;

                //Validate the File Height and Width.
                image.onload = function () {
                    var height = this.height;
                    var width = this.width;
                    if(height >= 500 && width >= 800) {
                        $('#'+id).css('margin-top', '5'+'px');    
                        $('#'+id).attr('width', '100');
                        $('#'+id).attr('height', '100');
                        $('#'+id).attr('src', e.target.result); 
                    }else{
                        $('#photo-error').html('Image width and height must not be below 800px and 500px respectively');
                        $('#photo-error').removeClass('d-none');
                        self.val('');
                        setInterval(()=>{ 
                            $('#photo-error').html('');
                            $('#photo-error').addClass('d-none');
                        }, 10000); 
                    }
                };
            };
        })

        
    </script>
@stop
