@extends('layouts/admin')

@section('css')
    <style type="text/css">
        .collection-select{
            min-height:150px;
        }
    </style>
@stop
@section('content')

 <!-- Begin Page Content -->
 <div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-inline-flex">
                <a href="{{url('admin/slides')}}">Slides</a> / 
                <p class="m-0 font-weight-bold text-secondary">Add a Slide Photo</p>
            </div>
        </div>
        <div class="card-body">
           
                <div if="form-container">
                    {!! Form::open(['url' => "admin/slide/save",'method' => 'post', 'files' => true, 
                        'id'=>'slideForm', 'class'=>'form-horizontal', ])
                    !!}
                    @include('inc.message')

                        <div class="form-group">
                            <h4>photo</h4>
                            <span style="color:red">(Must be minimum width and height of 1400px and 800px respectively)</span>
                            <p id="photo-error" class="alert alert-danger d-none"></p>
                            <div><img src="" id="collection-image" /></div>
                            <input type="file" class="form-control input-file" data-id="collection-image" name="photo" accept="image/*" required />
                        </div>
                        
                        <div class="form-group">
                            {{ Form::submit(__('Save'), array('class'=>'form-control  mt-4 btn btn-primary'))}}
                        </div>
                    {!! Form::close() !!} 
                </div>
            
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@stop

@section('js')
    <script type="application/javascript">
        $(document).ready(function() {
            $(document).on('change', '.input-file', function(e) {
                var photo = e.target.files;
                console.log(photo[0]);
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
                        if(height >= 800 && width >= 1400) {
                            $('#'+id).css('margin-top', '5'+'px');    
                            $('#'+id).attr('width', '100');
                            $('#'+id).attr('height', '100');
                            $('#'+id).attr('src', e.target.result); 
                        }else{
                            $('#photo-error').html('Image width and height must not be below 1400px and 800px respectively');
                            $('#photo-error').removeClass('d-none');
                            self.val('');
                            setInterval(()=>{ 
                                $('#photo-error').html('');
                                $('#photo-error').addClass('d-none');
                            }, 10000); 
                        }
                    };
                };
                //app.filesChange(e.target, e.target.files);
            })
        })
    </script>
@stop
