@extends('layouts/admin')

@section('content')

    <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Orders</h6>
                </div>
                
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-pending-tab" data-toggle="tab" href="#nav-pending" role="tab" aria-controls="nav-pending" aria-selected="true">Pending Orders</a>
                    <a class="nav-item nav-link" id="nav-completed-tab" data-toggle="tab" href="#nav-completed" role="tab" aria-controls="nav-completed" aria-selected="false">Completed Orders</a>
                </div>
            </nav>

        <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-pending" role="tabpanel" aria-labelledby="nav-pending-tab">
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

                <div class="tab-pane fade" id="nav-completed" role="tabpanel" aria-labelledby="nav-completed-tab">
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

        </div>

    </div>
                                
@stop


