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
		.productPhotos img {
            border-radius: 10px;
        }
        #productPhotos p {
            font-size: 15px;
        }
        #productPhotos {
            display: flex;
            text-align: center;
            justify-content:center;
            width: 100%;
        }
        .icons {
            transform: scale(1.2);
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
            <select name="collection-id" id="collection-select" class="categorySelect d-none">
                <option value="">Select Collection</option>
                @if($collections->count() > 0)
                    @foreach($collections as $collection) <option value="{{$collection->id}}">{{$collection->name}}</option> @endforeach
                @endif
            </select>
        <div class="card-body">
            @include('inc.message')
            <p id="msg" class="text-center alert d-none"></p>

            <!-- Removing Photo -->
            <h5 id="removing" class="alert alert-light d-none">Removing photo...
                <img src="{{asset('/assets/img/deleting.gif') }}" alt="">
            </h5>

            <div class="row">
                <div class="col-md-12 mt-5">
                    @if($products->count() > 0)
                        @foreach($products as $product)
                            <h4>{{$product->name}}</h4>
                            <div id="productPhotos" class="row mt-2">
                                @if($product->photos->count() > 0)
                                    @foreach($product->photos as $photo)
                                        <div class="col-md-3 productPhotos">
                                            <img src="{{$photo->file->thumb}}" height="150" alt="">
                                            <div class="container" style="display: flex; justify-content: space-around; padding-right:2em; padding-left:2em">
                                                <span class="icons">
                                                    <a href="javascript:void(0)"><i class="fa fa-trash remove" aria-hidden="true" data-id="{{$photo->id}}"></i></a>
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p>No photos for this product yet</p>
                                @endif
                                
                            </div>
                            <hr/>
                        @endforeach
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

        $('.remove').click(function() {
            if(confirm('Are you Sure you want to remove this photo?')) {
                const id = $(this).data('id');
                console.log('id:',id);
                isDeleting(true);
                let url = "{{url('admin/photo/remove/')}}/"+id;
                axios.get(url)
                .then((res) => {
                    console.log('response: ',res);
                    isDeleting(false);
                    if(res.status == 200) {
                        let ele = $(this).parent().parent().parent().parent();
                        ele.remove();
                    }
                    refreshPhotos();
                })
                .catch((error) => {
                    console.log(error);
                    isDeleting(false);
                })
            }
        })

        function isDeleting(status)
        {
            if(status){ 
                $('#removing').removeClass('d-none');
                $('.fa-trash').each(function() {
                    $(this).addClass('d-none');
                })
            }else{
                $('#removing').addClass('d-none');
                $('.fa-trash').each(function() {
                    $(this).removeClass('d-none');
                })
            }
        }

        function refreshPhotos() 
        {
            let url = "{{url('admin/photo/refresh/product')}}";
            axios.get(url)
            .then((res) => {
                console.log('refreshed photos')
                console.log('response: ',res);
            })
            .catch((error) => {
                console.log(error);
            })
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
