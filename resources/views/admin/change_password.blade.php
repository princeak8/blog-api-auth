@extends('layouts/admin')

@section('content')

 <!-- Begin Page Content -->
 <div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-inline-flex">
                <a href="{{url('admin')}}">Dashboard</a> / 
                <p class="m-0 font-weight-bold text-secondary">Change Password</p>
            </div>
        </div>
        <div class="card-body">
           
                <div if="form-container">
                    {!! Form::open(['url' => "admin/change_password",'method' => 'post', 'class'=>'form-horizontal', ]) !!}
                    @include('inc.message')

                        <div class="form-group">
                            {{Form::label('Current Password')}}
                            <div class="row">
                                <input type="password" name="old_password" class="form-control col-10" placeholder="Current Password" />
                                <div class="col-1">
                                    <input type="checkbox" class="show-pass" /><span>Show</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::label('New Password')}}
                            <div class="row">
                                <input type="password" name="password" class="form-control col-10" placeholder="New Password" />
                                <div class="col-1">
                                    <input type="checkbox" class="show-pass" /><span>Show</span>
                                </div>
                            </div>
                        </div>
                       
                        <div class="form-group">
                            {{ Form::submit('Change', array('class'=>'form-control  mt-4 btn btn-primary'))}}
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
        $('.show-pass').change(function() {
            if($(this).is(":checked")) {
                $(this).parents().siblings('input[type=password]').attr('type', 'text');
            }else{
                $(this).parents().siblings('input[type=text]').attr('type', 'password');
            }
        })
    </script>
@stop