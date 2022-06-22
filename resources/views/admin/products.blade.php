@extends('layouts/admin')

@section('content')

 <!-- Begin Page Content -->
 <div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Products <a href="{{url('admin/product/create')}}" class="btn btn-sm btn-primary ml-3">Add Product</a></h6>
        </div>
        <div class="card-body">
            @if($products->count() > 0)
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-4">
                            <img src="{{ $product->mainthumb }}" alt="" title="" style="width:100%; height:18em; object-fit: cover;" />
                            <span>{{$product->name}}</span><br/>
                            <span>N{{number_format($product->price)}} | Qty: {{$product->quantity}}</span><br/>
                            @foreach($product->collections as $collection)
                                {{$collection->name}} | 
                            @endforeach
                            <br/>
                            <a href="{{url('admin/product/'.$product->id)}}" class="btn btn-primary">View</a>
                            <a href="{{url('admin/product/edit/'.$product->id)}}" class="btn btn-warning">Edit</a>
                            <a href="{{url('admin/product/delete/'.$product->id)}}" class="btn btn-danger">Delete</a>
                        </div>
                    @endforeach
                </div>
            @else
                <p>No Products has been added at this point</p>
            @endif
                
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@stop