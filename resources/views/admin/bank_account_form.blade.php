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
                <a href="{{url('admin/collections')}}">Bank Accounts</a> / 
                <p class="m-0 font-weight-bold text-secondary">{{$title}}</p>
            </div>
        </div>
        <div class="card-body">
           
                <div if="form-container">
                    {!! Form::model($bankAccount, ['url' => "admin/save_bank_account?id=$bankAccount->id",'method' => 'post', 
                        'id'=>'collectionForm', 'class'=>'form-horizontal', ])
                    !!}
                    @include('inc.message')
                        <div class="form-group">
                            {{Form::text("name", old("name"), ["class" => "form-control","placeholder"=>"Account Name","required"=>"required"]) }}
                        </div>

                        <div class="form-group">
                            {{Form::text("number", old("number"), ["class" => "form-control","placeholder"=>"Account Number","required"=>"required"]) }}
                        </div>

                        <div class="form-group">
                            {{Form::select("bank_id", $banksData, $bankAccount->bank_id,
                                ["class"=>"form-control form-select size-select", 'required'=>'required']
                            )}}
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
