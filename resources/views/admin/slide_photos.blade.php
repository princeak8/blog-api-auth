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
        .slidePhotos img {
            border-radius: 10px;
            margin-top: 3em;
        }
        .icons {
            transform: scale(1.5);
            margin: 1em;
        }
        .fa-trash {
            color: red;
        }        
    </style>
@stop

@section('content')

 <!-- Begin Page Content -->
 <div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
                @include('layouts/admin/photos_header')
                <div class="top-link">
                <a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="addPhotos()">Save</a>

                <a href="{{url('admin/refresh_slide_photos')}}" class="btn btn-primary" style="float:right; color:#fff">Refresh</a>
            </div>
            <div class="card-body">
                @include('inc.message')
                <p id="msg" class="text-center alert d-none"></p>
            
                <!-- Adding Photos to Slide -->
                <h5 id="adding" class="alert alert-light d-none">Adding photos...
                    <img src="{{asset('/assets/img/file-transfer.gif') }}" alt="">
                </h5>
                
                <div id="slidePhotos" class="row mt-2">
                    @if(count($photos) > 0) <?php $i = 0; ?>
                        @foreach($photos as $photo)
                            <?php $i++; ?>
                            <div class="col-md-3 slidePhotos mt-4 text-center">
                                <img src="{{$photo->thumb}}" height="150" alt="">
                                <div class="container" style="display: flex; justify-content: space-around; padding-right:2em; padding-left:2em">
                                    <span class="icons">
                                        <input 
                                            type="checkbox" id="photo{{$i}}" class="slide-box" value="{{$photo->file}}"
                                            data-thumb="{{$photo->thumb}}" data-size="{{$photo->size}}"
                                            @if($photo->active) checked @endif
                                        />
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>No Slide Photos found</p>
                    @endif   
                </div>
            </div>
        </div>
    </div>
    <input type="text" name="category" value="product"/>

</div>
<!-- /.container-fluid -->
@stop

@section('js')
    <script type="application/javascript">
        var checkedPhotosArr = [];

        $(document).on('click', '.slide-box', function(e){
            console.log('clicked');
            if(this.checked == true) {
                let file = this.value;
                let thumb = $(this).data("thumb");
                let size = $(this).data("size");
                checkedPhotosArr.push({file, thumb, size});
                console.log(checkedPhotosArr);
            }
        });

        function addPhotos()
        {
            //console.log(checkedPhotosArr);
            let category = 'slide';
            let errorMsg = '';
            //When the save button has been clicked
            isAdding(true);
            //Make a POST Request using axios to Add photos to slides
            let url = "{{url('admin/photo/add_to_category')}}";
            var token = $('meta[name="csrf-token"]').attr('content');
            let formData =  {photos: checkedPhotosArr, category: category, _token: token};
            console.log('formdata: ',formData);
                        
            axios.post(url, formData)
            .then((res) => {
                console.log('response: ',res);
                isAdding(false);
            })
            .catch((error) => {
                console.log(error);
                isAdding(false);
            })    
        }

        function isAdding(status)
        {
            if(status){ 
                $('#adding').removeClass('d-none');
                $('.slide-box').each(function() { 
                    $(this).prop("disabled", true);
                }); 
            }else{
                $('#adding').addClass('d-none');
                $('.slide-box').each(function() { 
                    $(this).prop("disabled", false);
                });
            }
        }

    </script>

   
@stop
