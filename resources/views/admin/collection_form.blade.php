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
                <a href="{{url('admin/collections')}}">Collections</a> / 
                <p class="m-0 font-weight-bold text-secondary">{{$title}}</p>
            </div>
        </div>
        <div class="card-body">
           
                <div if="form-container">
                    {!! Form::model($collection, ['url' => "admin/collection/save?id=$collection->id",'method' => 'post', 'files' => true, 
                        'id'=>'collectionForm', 'class'=>'form-horizontal', ])
                    !!}
                    @include('inc.message')
                        @if(strtolower($collection->name) != strtolower('New Arrivals'))
                            <div class="form-group">
                                {{Form::text("name", old("name"), ["class" => "form-control","placeholder"=>"Collecction Name","required"=>"required"]) }}
                            </div>
                        @endif
                       
                        <p>Add Product(s) to Collection</p>
                        <div class="form-group row">
                            <div class="col-6">
                            {{Form::select("products[]", $productsData, $productCollections,
                                            ["multiple"=>"multiple", "class"=>"form-control form-select collection-select", "data-id"=>"selected-collection", 
                                                'id'=>'collections'
                                            ]
                                        )
                                }}
                            </div>
                            <div class="col-6">
                                <select id="selected-collection" multiple class="form-control collection-select">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::textarea("description", old("description"), ["class" => "form-control", "placeholder"=>"Description of collection"]) }}
                        </div>
                        <!-- @if($collection->name!='New Arrivals')
                            @if(!empty($collection->photo))
                                <div class="col-6">
                                    <img src="{{ asset('uploads/collections/thumbnails/'.$collection->photo) }}" alt="" title="" style="width:80%; height:16em;" />
                                </div>
                            @else
                                <p>No photo for this collection</p>
                            @endif

                            <div class="form-group">
                                <h4>Collection cover photo</h4>
                                <span style="color:red">(Must be minimum width and height of 800px and 500px respectively)</span>
                                <p id="photo-error" class="alert alert-danger d-none"></p>
                                <div><img src="" id="collection-image" /></div>
                                <input type="file" class="form-control input-file" data-id="collection-image" name="photo" accept="image/*" @if($collection->id == null) required @endif />
                            </div>
                        @endif -->
                        <input type="hidden" name="id" value="{{$collection->id}}" />
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
            var Options = '';
            $('#collections :selected').each(function(e) {
                Options += `<option class="col-12" value="${this.value}">${this.text}</option>`
            })
            $('#selected-collection').html(Options);

            $("select[multiple] option").mousedown(function () {
                var selectOptions = '';
                var $self = $(this);            
                var id = $(this).parent().attr('id');
                var id2 = $(this).parent().data("id");
                if ($self.attr("selected")) {                
                    $self.removeAttr("selected", "");
                }
                else {
                    $self.attr("selected", "selected");
                }
                $("#"+id+" :selected").each(function() {
                    selectOptions += `<option class="col-12" value="${this.value}">${this.text}</option>`
                });
                $('#'+id2).html(selectOptions);

                return false;            
            });

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
                //app.filesChange(e.target, e.target.files);
            })
        })
    </script>
@stop
