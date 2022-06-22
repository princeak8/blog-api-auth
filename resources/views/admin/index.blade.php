@extends('layouts/admin')

@section('content')
 <!-- Content Row -->
 <div class="container-fluid">
        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Products</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                </div>
                </div>
            </div>
            </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Collections</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                </div>
                </div>
            </div>
            </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pending Orders</div>
                    <div class="row no-gutters align-items-center">
                    <div class="col-auto">
                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">0</div>
                    </div>
                    <div class="col">
                        <div class="progress progress-sm mr-2">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
                </div>
            </div>
            </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Confirmed Payments</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-comments fa-2x text-gray-300"></i>
                </div>
                </div>
            </div>
            </div>
            </div>
        </div>

 </div>   
<!-- Content Row -->

<!-- Tables Section begins -->

 <!-- Begin Page Content -->
 <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Tables</h1>
<p class="mb-4">Below are your client's transaction details</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Products</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price (₦)</th>
            <th>Orders</th>
            <th>Actions</th>
          </tr>
        </thead>
        @if($products->count() > 0)
          <tbody>
            @foreach($products as $product)
              <tr>
                <td>{{$product->name}}</td>
                <td>{{$product->quantity}}</td>
                <td>N{{number_format($product->price)}}</td>
                <td>{{$product->order_products->count()}}</td>
                <td><a href="{{url('admin/product/edit/'.$product->id)}}" class="btn btn-primary">Edit</a></td>
              </tr>
            @endforeach
          </tbody>
        @endif
        </table>
        @if($products->count()==0)
          <p>No Product has been added at this point</p>
        @endif

    </div>
  </div>
</div>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Collections</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Name</th>
            <th>Actions</th>
          </tr>
        </thead>
        @if($collections->count() > 0)
        <tbody>
        @foreach($collections as $collection)
          <tr>
            <td>{{$collection->name}}</td>
            <td><a href="{{url('admin/collection/edit/'.$collection->id)}}" class="btn btn-primary">Edit</a></td>
          </tr>
          @endforeach
        </tbody>
        @endif
      </table>
      @if($collections->count()==0)
      <p>No Collection has been added at this point</p>
        @endif
    </div>
  </div>
</div>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Orders</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Order No.</th>
            <th>Client Name</th>
            <th>Order Date</th>
            <th>Amount (₦)</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        @if($orders->count() > 0)
        <tbody>
        @foreach($orders as $order)
          <tr>
            <td>07</td>
            <td>Tiger Musk</td>
            <td>19/02/2021</td>
            <td>35000</td>
            <td>Deliverd</td>
            <td><a href="#" class="btn btn-primary">Edit</a></td>
          </tr>
          @endforeach          
        </tbody>
        @endif
      </table>
      @if($orders->count()==0)
      <p>No Order has been added at this point</p>
        @endif
    </div>
  </div>
</div>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Payments</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>Order No.</th>
            <th>Payment Date</th>
            <th>Amount (₦)</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        @if($payments->count() > 0)
        <tbody>
        @foreach($payments as $payment)
          <tr>
            <td>07</td>
            <td>19/02/2021</td>
            <td>60000</td>
            <td>paid</td>
            <td><a href="#" class="btn btn-primary">Edit</a></td>
          </tr>
          @endforeach            
        </tbody>
        @endif
      </table>
      @if($payments->count()==0)
      <p>No Payment has been added at this point</p>
        @endif

    </div>
  </div>
</div>

</div>
<!-- /.container-fluid -->

<!-- Tables Section ends -->
@stop
