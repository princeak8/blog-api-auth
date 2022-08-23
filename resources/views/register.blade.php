@extends('layouts/main')
    
@section('content')

<body class="bg-gradient-primary">

  <div class="container">

      <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
              <!-- Nested Row within Card Body -->
              <div class="row">
                  <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>

                  <div class="col-lg-7">
                      <div class="p-5">
                          <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                          </div>
                          {!! Form::open(["url"=>"register_user", "method"=>"post", "class"=>"user"]) !!}
                            @include('inc.message')
                                <div class="form-group">
                                    <input type="text" name="domain_name" class="form-control form-control-user" id="exampleDomain" placeholder="Account Domain name" value="{{old('domain_name')}}">
                                </div>                             
                                <div class="form-group">
                                      <input type="text" name="domain" class="form-control form-control-user" id="exampleDomain" placeholder="Account Domain" value="{{old('domain')}}">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Email" value="{{old('email')}}">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="Register"  class="btn btn-primary btn-user btn-block">
                                </div>
                        
                          {{ Form::close() }}
                      </div>
                  </div>
              </div>
            
          </div>
      </div>

  </div>
@stop
