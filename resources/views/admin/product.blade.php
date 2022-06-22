@extends('layouts/admin')

@section('css')
    <style type="text/css">
        .title{
            font-weight: bold;
            font-size: 1em;
        }
        .dropbox {
			outline: 2px dashed grey; /* the dash box */
			outline-offset: -10px;
			background: lightcyan;
			color: dimgray;
			padding: 10px 10px;
			min-height: 200px; /* minimum height */
			position: relative;
			cursor: pointer;
		}

		.input-file {
			opacity: 0; /* invisible but it's there! */
			width: 100%;
			height: 200px;
			position: absolute;
			cursor: pointer;
		}

		.dropbox:hover {
			background: lightblue; /* when mouse over to the drop zone, change color */
		}

		.dropbox p {
			font-size: 1.2em;
			text-align: center;
			padding: 50px 0;
		}
    </style>
@stop
@section('content')

 <!-- Begin Page Content -->
 <div class="container-fluid">
    <div class="card shadow mb-4">
    <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{$product->name}}<a href="{{url('admin/product/edit/'.$product->id)}}" class="btn btn-sm btn-warning ml-3">Edit</a></h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-8">
                    @foreach($product->photos as $productPhoto)
                        <img id="photo-{{$productPhoto->id}}" src="{{ $productPhoto->file->secure_url }}" alt="" title="" 
                            @if($productPhoto->file->secure_url==$product->main) 
                                class="photos d-block" 
                            @else 
                                class="photos d-none" 
                            @endif 
                            style="width:100%; height:30em;" 
                        />
                    @endforeach
                    <!-- <h3>Product Photos<button type="button" id="add-photo" data-open="0" class="btn btn-sm btn-primary ml-3">Add Photo(s)</a></h3>
                    <div id="app" class="d-none form-group">
                        {!! Form::model($product, ['url' => "admin/product/photo/save?id=$product->id",'method' => 'post', 'files' => true, 
                            'id'=>'photoForm', 'class'=>'form-horizontal', 'onsubmit'=>'return save();'])
                        !!}
                            @include('inc.message')
                            <p v-if="photoError != ''" class="col-12 alert alert-danger">@{{photoError}}</p>
                            <div class="dropbox">
                                <div id="photos">
                                    <input type="file" multiple name="photos[]" class="input-file" accept="image/*" required>
                                </div>
                                        
                                <p v-if="isInitial">
                                    Drag your file(s) here to begin<br> or click to browse 
                                </p>
                                        
                                <div v-else>
                                    <img v-for="f in uploadedFiles" width="120" height="100" :src="f.photo" style="margin-right: 1%" /> 
                                </div>
                            </div>
                            <div class="col-4">
                                <p v-if="!isInitial" v-for="f in uploadedFiles" :key="f.name" style="font-size:0.8em; display: flex; flex-direction: row">
                                    @{{f.name}}
                                    <a href="javascript:void(0)" class="col-md-2" @click="removePhoto(f.name)" style="color:red">X</a>
                                </p>
                            </div>
                            <input type="hidden" name="deleted_photos" />
                            <input type="hidden" name="edit" value="0" />
                            <div class="row">
                                {{ Form::submit('Add', array('class'=>'form-control  mt-4 btn btn-primary'))}}
                            </div>
                        {!! Form::close() !!} 
                    </div> -->
                    
                    <div id="thumbnails" class="row">
                        @foreach($product->photos as $productPhoto)
                            <div class="col-3">
                                
                                <img data-id="photo-{{$productPhoto->id}}" class="thumb-photo" src="{{ $productPhoto->file->thumb }}" alt="" title="" style="width:100%; height:10em;" />
                                <p class="alert alert-danger d-none" id="photo-main-error-{{$productPhoto->id}}">this is an error</p>
                                <div class="row">
                                   <span class="pt-1"> Main</span>
                                   <input type="radio" class="col-4 form-control" name="main" value="{{$productPhoto->id}}" @if($productPhoto->file->secure_url==$product->main) checked @endif />
                                    
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-4">
                    <div class="row">
                        <span class="title pr-4">Price: </span>
                        <span>N{{number_format($product->price)}}</span>
                    </div>
                    <div class="row mt-4">
                        <span class="title pr-4">Quantity: </span>
                        <span>{{$product->quantity}}</span>
                    </div>
                    <div class="mt-4">
                        <h3><b>Description: </b></h3>
                        <p>{{$product->description}}</p>
                    </div>
                </div>
            </div>
                
        </div>
    </div>
    <input type="hidden" name="product_id" value="{{$product->id}}" />
</div>
<!-- /.container-fluid -->
@stop
@section('js')
    <script type="application/javascript">
        $(document).ready(function() {
            $('.thumb-photo').click(function() {
                var id = $(this).data('id');
                
                $('.photos').each(function(i, ele) {
                    console.log('thumb');
                    $(this).removeClass('d-block');
                    $(this).addClass('d-none');
                })
                $('#'+id).addClass('d-block');
            })
            $('input[name=main]').change(function() {
                console.log('change');
                var productId = $('input[name=product_id]').val();
                var photoId = $(this).val();
                var url = "{{url('admin/product/change_main')}}";
                var formData =  {product_id:productId, photo_id: photoId};
                //console.log(photoId);
                var self = $(this)
                axios.post(url, formData)
                    .then(function (res) {
                        console.log('status: ',res.data.statusCode);
                        if(res.data.statusCode != 200) {
                            console.log('heloo');
                            self.prop('checked', false);
                            $('#photo-main-error-'+photoId).html(res.data.message);
                            $('#photo-main-error-'+photoId).removeClass('d-none');
                            setTimeout(
                                () => {
                                    $('#photo-main-error-'+photoId).addClass('d-none');
                                },
                                30000);
                        }
                    })
                    .catch(function(error) {
                        console.log("An error occured while trying to perform the operation "+error.message);
                        $(this).attr('checked',false);
                    });
            })
            $('#add-photo').click(function() {
                var open = $(this).data('open');
                if(open==0) {
                    $('#app').removeClass('d-none');
                    $('#app').addClass('d-block');
                    $(this).data('open', '1');
                    $(this).html('close');
                    $(this).removeClass('btn-primary');
                    $(this).addClass('btn-danger');
                }else{
                    $('#app').removeClass('d-block');
                    $('#app').addClass('d-none');
                    $(this).data('open', '0');
                    $(this).html('Add Photo(s)');
                    $(this).removeClass('btn-danger');
                    $(this).addClass('btn-primary');
                }
            })
        })
        
        $(document).on('change', '.input-file', function(e) {
            app.filesChange(e.target, e.target.files);
            this.style.display = "none";
            $('#photos').append(`<input type="file" multiple name="photos[]" class="input-file" accept="image/*">`);
        })

        function save()
        {
            if(app.photos.length <= 0) {
                app.photoError = "Please add atleast one photo";
                console.log(app.deletedPhotos);
                setInterval(()=>{ app.photoError = ''; }, 5000);
                return false;
            }else{
                $('input[name=deleted_photos]').val(app.deletedPhotos);
                console.log(app.deletedPhotos);
                return true;
            }
            return true;
        }

        var app = new Vue({
			el: '#app',             
			computed: {
				isInitial() {
					return this.photos.length == 0;
				}
			},
			data: {
				photos: [],
                uploadedFiles: [],
                uploadError: null,
                currentStatus: null,
                uploadFieldName: 'photos',
                photoError: '',
                deletedPhotos: [],
            },
            methods: {
                removePhoto(pix) {
                    this.deletedPhotos.push(pix);
                    console.log('remove Photo');
                    var n = 0;
                    this.photos.forEach((photo, k)=>{
                        if(photo.name==pix) {
                            console.log('delete ',pix);
                            this.photos.splice(n, 1);
                        }
                        n = n + 1;
                    })
                    var n = 0;
                    this.uploadedFiles.forEach((file, k)=>{
                        if(file.name==pix) {
                            this.uploadedFiles.splice(n, 1);
                        }
                        n = n + 1;
                    })
                    if(this.photos.length < 6) {
                        this.photoError = "";
                    }
                },
                filesChange(fieldName, fileList) {
                    this.photoError = "";
                    // handle file changes
                    console.log('photos: ',fileList);
                    if(fileList.length > 0 && this.photos.length < 6) {
                        var self = this;
                        var rejectedPhotos = '';
                        Array.from(fileList).forEach((file, key)=> {
                            if(file && this.photos.length < 6) {
                                //check if there are photos that has been deleted
                                if(this.deletedPhotos.length > 0) {
                                    //loop through the deleted photos to know if the new photo added is the same as a deleted photos and if so, remove it from the array
                                    var n = 0;
                                    this.deletedPhotos.forEach((p, k2)=>{
                                        if(p==file.name) {
                                            this.deletedPhotos.splice(n, 1);
                                        }
                                        n = n + 1;
                                    })
                                }
                                if(this.photos.length > 0) {
                                    
                                    var exists = false;
                                    this.photos.forEach((f, k) =>{
                                        if(file.name == f.name) {
                                            exists = true;
                                        }
                                    })
                                    if(!exists) {
                                        const reader = new FileReader
                                        reader.onload = e => {
                                            var image = new Image();
                                            image.src = e.target.result;
                                            image.onload = function() {
                                                // access image size here 
                                                if(this.width < 500 || this.height < 400) {
                                                    self.deletedPhotos.push(file.name);
                                                    rejectedPhotos = rejectedPhotos+file.name+', ';
                                                    self.photoError = rejectedPhotos+' Must have width of at least 500pixels and height 400pixels';
                                                    setInterval(()=>{ self.photoError = ''; }, 7000);
                                                }else{
                                                    self.photos.push(file);
                                                    self.uploadedFiles.push({photo:e.target.result, name:file.name});
                                                }
                                            };
                                        }
                                        reader.readAsDataURL(file);
                                    }else{
                                        console.log('photo exists');
                                    }
                                }else{
                                    const reader = new FileReader;
                                    reader.onload = e => {
                                        var image = new Image();
                                        image.src = e.target.result;
                                        image.onload = function() {
                                            // access image size here 
                                            if(this.width < 500 || this.height < 400) {
                                                self.deletedPhotos.push(file.name);
                                                rejectedPhotos = rejectedPhotos+file.name+', ';
                                                self.photoError = rejectedPhotos+' Must have width of at least 500pixels and height 400pixels';
                                                setInterval(()=>{ self.photoError = ''; }, 7000);
                                                console.log('width: '+this.width+' height: '+this.height);
                                            }else{
                                                self.photos.push(file);
                                                self.uploadedFiles.push({photo:e.target.result, name:file.name});
                                            }
                                        };
                                    }
                                    reader.readAsDataURL(file)
                                }
                            }else if(this.photos.length >= 6) {
                                this.photoError = "Maximum Number of Photos that you can upload at once reached";
                            }
                        })
                        /**/
                    }else if(this.photos.length >= 6) {
                        this.photoError = "Maximum Number of Photos that you can upload at once reached";
                    }
                }
            },

        });
    </script>
@stop
