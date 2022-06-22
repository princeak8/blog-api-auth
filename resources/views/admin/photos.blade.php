@extends('layouts/admin')

@section('css')
    <style type="text/css">
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
        .activv, .top-text:hover {
            font-size: 20px;
            margin: 0.5em;
            transition-timing-function: ease-in;
            transition: 0.8s;
		}
        .top-link{
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }
        .top-link-inner{
            display: flex;
            flex-direction: row;
            font-size: 12px;
        }
		.dropbox p {
			font-size: 1.2em;
			text-align: center;
			padding: 50px 0;
		}
        #loading img {
            position:absolute;
            transform: scale(0.5);
            height:14em;
            left:40%;
            top:8.5em;
            border-radius: 50%;
        }
        .icons {
            transform: scale(1.5);
        }
        .fa-trash {
            color: red;
        }
        #adding {
            display: flex;
            justify-content: center; 
            align-items: center; 
            width: 98%; 
            border: solid 2px green;
            color: blue;
        }
        #adding img {
            height: 4em;
            width: auto;
            border-radius: 10px;
            margin-left: 7em;
        }
        .delete {
            display: none;
        }
    </style>
@stop

@section('content')
        
 <!-- Begin Page Content -->
 <div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Product-Gallery</h6>
            @include('layouts/admin/photos_header')
            <div class="row">
                <select name="product-id" id="product-select" class="categorySelect form-control col-4">
                    <option value="">Select Product</option>
                    @if($products->count() > 0)
                        @foreach($products as $product) <option value="{{$product->id}}">{{$product->name}}</option> @endforeach
                    @endif
                </select>
                <div class="top-link col-2">
                    <a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="addPhotos()">Save</a>
                </div>
            </div>

            <div class="card-body">
                @include('inc.message')
                <div class="row"> 
                    <p id="loading" class="d-none mb-3" style="height: 4em;"><img src="{{asset('/assets/img/loading-spinner.gif') }}"></p>
                    <div id="errors" class="d-none">
                        <span class="alert alert-danger"></span>
                    </div>
                    <h5 id="adding" class="alert alert-light d-none">Adding photos...
                        <img src="{{asset('/assets/img/file-transfer.gif') }}" alt="">
                    </h5>
                    <div id="dropboxPhotos" class="row mt-5"></div>
                    <input type="hidden" value="{{$email}}" name="email" />      
                </div>
            </div>
    </div>
</div>
<!-- /.container-fluid -->
@stop

@section('js')
    <script type="application/javascript">
        
        var checkedPhotosArr = [];
        
        $(document).on('click', '.checkbox', function(e){
            //console.log('clicked');
            if(this.checked == true) {
                let id = this.id;
                let file = this.value;
                let thumb = $(this).data("thumb");
                let url = $(this).data("url");
                let size = $(this).data("size");
                checkedPhotosArr.push({file, thumb, url, size, id});
                
            } else {
                    // REMOVE VALUE FROM ARRAY WHEN IT IS UNCHECKED
                checkedPhotosArr = checkedPhotosArr.filter(e => e.file !== this.value);
            }
            console.log(checkedPhotosArr);
        });

        $("#top-linksId").on('click', 'a', function () {
            $("#top-linksId a.activv").removeClass("activv");
            // adding classname 'activv' to current clicked a 
            $(this).addClass("activv");
        });

        function isAdding(status)
        {
            if(status){ 
                $('#adding').removeClass('d-none');
                $('.fa-trash').addClass('delete');
                $('.checkbox').each(function() { 
                    $(this).prop("disabled", true);
                }); 
            }else{
                $('#adding').addClass('d-none');
                $('.fa-trash').removeClass('delete');
                $('.checkbox').each(function() { 
                    $(this).prop("disabled", false);
                });
            }
        } 

        function addPhotos()
        {
            //Adding selected photos to their corresponding categories
            //console.log('adding photos');
            //console.log(checkedPhotosArr);
            let category = 'product';
            //if(category=='product') {
            let id = 0;
            let errorMsg = "please choose a product";
            id = $('select[name=product-id]').val(); 
            if(id != '') {
                //When the save button has been clicked
                isAdding(true);
                //Make a POST Request using axios to Add photos to products
                let url = "{{url('admin/photo/add_to_category')}}";
                var token = $('meta[name="csrf-token"]').attr('content');
                let formData =  {photos: checkedPhotosArr, id: id, category: category, _token: token};
                console.log('formdata: ',formData);
                    
                axios.post(url, formData)
                .then((res) => {
                    console.log('response: ',res);
                    isAdding(false);
                    if(res.status == 200) {
                        checkedPhotosArr.forEach(({ id }) => {
                            //file = getFilenumber(file);
                            $('#'+id).remove();
                        })
                        checkedPhotosArr = [];
                    }
                })
                .catch((error) => {
                    console.log(error);
                    isAdding(false);
                })

            }else{
                console.log(errorMsg);
                $('#errors span').html('Error: '+errorMsg);
                $('#errors').removeClass('d-none');
            }
        }

        function removeSelectCategories()
        {
            $('.categorySelect').each(function(e) {
                $(this).addClass('d-none');
            })
        }

        $('.dropdown-menu').on('click', function(event){
            var events = $._data(document, 'events') || {};
            events = events.click || [];
            for(var i = 0; i < events.length; i++) {
                if(events[i].selector) {

                    //Check if the clicked element matches the event selector
                    if($(event.target).is(events[i].selector)) {
                        events[i].handler.call(event.target, event);
                    }

                    // Check if any of the clicked element parents matches the 
                    // delegated event selector (Emulating propagation)
                    $(event.target).parents(events[i].selector).each(function(){
                        events[i].handler.call(this, event);
                    });
                }
            }
            event.stopPropagation(); //Always stop propagation
        });
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
                //
            },
            methods: {
                //
            },

        });

        function isLoading(status)
        {
            (status) ? $('#loading').removeClass('d-none') : $('#loading').addClass('d-none');
        }
        function getFilenumber(file) {
            let arr = file.split('_');
            let filename = arr[arr.length-1];
            let filenameArr = filename.split('.');
            return filenameArr[0];
        }
        $(document).ready(function() {
            //When document loads
            isLoading(true);
            //make a POST Request using axios to get dropbox photos

            let url = "{{url('admin/photo/get_dropbox_photos')}}";
            var token = $('meta[name="csrf-token"]').attr('content');
            let email = $('input[name=email]').val();
            let formData =  {email: email, category: 'product', _token: token};
            //console.log(`email: ${email} token: ${token}`);
            axios.post(url, formData)
            .then((res) => {
                isLoading(false);
                console.log('result ', res);
                if(res.status == 200) {
                    console.log('photos: ',res.data.photos);
                    let setWidth = 150;
                    if(Object.keys(res.data.photos).length > 0) {

                        //loop through the photos
                        let photoContent = '';
                        //let imgBinaryPrefix = 'data:image/jpg;base64,';
                        var i = 0;
                        res.data.photos.forEach((photo) => { i++;
                            let file = getFilenumber(photo.file);
                            console.log('file: ', photo.file);
                            photoContent += `
                            <div class="col-3" id="photo${i}">
                                <span>
                                    <img alt="" style="width:100%; height:24em; border-radius:10px; transform: scale(0.7); object-fit: cover;" class="lazyload img-back" src="${photo.thumb}" />
                                </span>
                                <div class="container" style="display: flex; justify-content: space-around; padding-right:2em; padding-left:2em">
                                    <span class="icons">
                                        <input type="checkbox" id="photo${i}" class="checkbox" name="" value="${photo.file}" data-thumb="${photo.thumb}" data-url="${photo.url}" data-size="${photo.size}" data-dimension="${photo.dimension}">
                                    </span>
                                    <span class="icons">
                                        <a href="#"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    </span>
                                </div>
                            </div>
                            `;
                        })
                        
                        $('#dropboxPhotos').html(photoContent);
                    }else{
                        //The photos is empty
                        $('#dropboxPhotos').html('<p> No photos available </p>');
                    } 
                }else{
                    console.log('error:', res.data.message);
                }
            })
            .catch((error) => {
                isLoading(false);
                console.log("An error occured while trying to perform the operation "+error.message);
                $('#dropboxPhotos').html('<p class="alert alert-danger">Oops!.. An error occured while attempting to fetch your photos, Please reload.. If error persists, contact the Administrator</p>');
                throw error;
            });

            //console log what we return
            //To enable adding more photos after initial multiple selections
            $(document).on('change', '.input-file', function(e) {
                app.filesChange(e.target, e.target.files);
                this.style.display = "none";
                $('#photos').append(`<input type="file" multiple name="photos[]" class="input-file" accept="image/*">`);
            })

            var Options = '';
            $('#collections :selected').each(function(e) {
                Options += `<option class="col-12" value="${this.value}">${this.text}</option>`
            })
            $('#selected-collection').html(Options);

            var Options2 = '';
            $('#sizes :selected').each(function(e) {
                Options2 += `<option class="col-12" value="${this.value}">${this.text}</option>`
            })
            $('#selected-size').html(Options2);

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
        })
    </script>
@stop
