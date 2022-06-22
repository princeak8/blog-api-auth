@extends('layouts/auth')
    
@section('content')

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                  </div>
                  {!! Form::open(["url"=>"login", "method"=>"post", "class"=>"user"]) !!}
                @include('inc.message')
                  
                    <div class="form-group">
                      <input type="email" name="email" class="form-control form-control-user" id="loginInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" class="form-control form-control-user" id="loginInputPassword" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <input type="submit" value="Login"  class="btn btn-primary btn-user btn-block">
                    </div>
                    {{ Form::close() }}
                  <hr>
                  
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

@stop