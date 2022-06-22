@extends('layouts/admin', (array)$meta)

@section('content')
    <p>Register a new Admin User</p>
    {{ Form::open(array('url' => 'admin/register', 'method'=>'post')) }}

    {{ Form::close() }}
@stop