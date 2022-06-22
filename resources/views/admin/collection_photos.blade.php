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
		.collectionPhotos h6 {
            margin-top: 1em;
        }
        .collectionPhotos img {
            border-radius: 10px;
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
        <div class="card-header py-3" style="border: solid #000 thin">
            @include('layouts/admin/photos_header')
            <a href="{{url('admin/refresh_collection_photos')}}" class="btn btn-primary" style="float:right; color:#fff">Refresh</a> 
            <div class="row">
                <select name="collection-id" id="collection-select" class="col-4">
                    <option value="">Select Collection</option>
                    @if($collections->count() > 0)
                        @foreach($collections as $collection) <option value="{{$collection->id}}">{{$collection->name}}</option> @endforeach
                    @endif
                </select>
                <a href="javascript:void(0)" class="btn btn-success btn-sm col-2" onclick="addPhotos()">Save</a>
            </div>
        </div>

        <div class="card-body">
            @include('inc.message')
            <p id="msg" class="text-center alert d-none"></p>
            
            <!-- Adding Photo to Collection -->
            <h5 id="adding" class="alert alert-light d-none">Adding photos...
                <img src="{{asset('/assets/img/file-transfer.gif') }}" alt="">
            </h5>

            <!-- Removing Photo -->
            <h5 id="removing" class="alert alert-light d-none">Removing photo...
                <img src="{{asset('/assets/img/deleting.gif') }}" alt="">
            </h5>
            
            <div id="collectionPhotos" class="row mt-5">
                @if(count($photos) > 0) <?php $i = 0; ?>
                    @foreach($photos as $photo)
                        <?php $i++; ?>
                        <div class="col-md-3 productPhotos mt-4 text-center">
                            <img src="{{$photo->thumb}}" height="150" alt="">
                            @if($photo->name != null) <p style='margin:0px; padding: 0px;'>{{$photo->name}}</p> @endif
                            <div class="container" style="display: flex; justify-content: space-around; padding-right:2em; padding-left:2em">
                                <span class="icons">
                                    <input 
                                        type="radio" id="photo{{$i}}" name="collectionPhoto" class="collection-box" value="{{$photo->file}}" data-selected="photo{{$i}}"
                                        data-id="{{$photo->collection_id}}" data-thumb="{{$photo->thumb}}" data-url="{{$photo->url}}" data-size="{{$photo->size}}"
                                    />
                                </span>
                                <span class="icons">
                                    <a href="#"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>No Collection Photos found</p>
                @endif
                
            </div>
           
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@stop

@section('js')
    <script type="application/javascript">
        var checkedPhoto = {};
        $(document).on('click', '.collection-box', function(e){
            console.log('clicked');
            // let ele = $(this).parent().parent();
            // console.log(ele);
            // $("<p style='margin:0px; padding: 0px;'>My name</p>").insertBefore(ele);
            if(this.checked == true) {
                let file = this.value;
                let thumb = $(this).data("thumb");
                let url = $(this).data("url");
                let size = $(this).data("size");
                let collection_id = $(this).data("id");
                let selected = $(this).data("selected");
                checkedPhoto = {file, thumb, url, size, collection_id, selected};
                (collection_id != '') ? $('select[name=collection-id').val(collection_id).change() : $('select[name=collection-id').val('').change();
                console.log(checkedPhoto);
            }
        });

        //Get the radiobox that is attached to a particular collection if it exists
        function getAttached(collectionId)
        {
            var radiobox = '';
            $('.collection-box').each(function() {
                if($(this).data('id') == collectionId) radiobox = $(this);
            })
            return radiobox;
        }

        function addPhotos()
        {
            //Adding selected photo to the collection
            let category = 'collection';
            let id = 0;
            let errorMsg = "please choose a Collection";
            id = $('select[name=collection-id]').val();
            var attachedRadiobox = getAttached(id);
            if(attachedRadiobox != '') checkedPhoto.collection_id = attachedRadiobox.data('id');
            if(id != '') {
                //When the save button has been clicked
                isAdding(true);
                //Make a POST Request using axios to Add photo to collection
                let url = "{{url('admin/photo/add_to_category')}}";
                var token = $('meta[name="csrf-token"]').attr('content');
                let formData =  {photos: checkedPhoto, id: id, category: category, _token: token};
                console.log('formdata: ',formData);
                        
                axios.post(url, formData)
                .then((res) => {
                    console.log('response: ',res);
                    isAdding(false);
                    if(res.status == 200) {
                        //console.log(attachedRadiobox);
                        if(attachedRadiobox != '') {
                            attachedRadiobox.data('id', '');
                            attachedRadiobox.parent().parent().siblings('p').remove();
                        }
                        let ele = $('#'+checkedPhoto.selected).parent().parent();
                        //console.log(ele);
                        $(`<p style='margin:0px; padding: 0px;'>${res.data.name}</p>`).insertBefore(ele);
                    }
                })
                .catch((error) => {
                    console.log(error);
                    isAdding(false);
                })

            }else{
                console.log(errorMsg);
                addMsg(errorMsg, false);
                setInterval(()=>{  
                    removeMsg();
                }, 5000);
            }
                
        }

        function isAdding(status)
        {
            if(status){ 
                $('#adding').removeClass('d-none');
                $('.fa-trash').addClass('delete');
                $('.collection-box').each(function() { 
                    $(this).prop("disabled", true);
                }); 
            }else{
                $('#adding').addClass('d-none');
                $('.fa-trash').removeClass('delete');
                $('.collection-box').each(function() { 
                    $(this).prop("disabled", false);
                });
            }
        }

        function addMsg(msg, success=true)
        {
            $('#msg').html(msg);
            (success) ? $('#msg').addClass('alert-success') : $('#msg').addClass('alert-danger');
            $('#msg').removeClass('d-none');
        }

        function removeMsg()
        {
            $('#msg').html('');
            $('#msg').removeClass('alert-danger');
            $('#msg').removeClass('alert-success');
            $('#msg').addClass('d-none');
        }

    </script>

@stop
