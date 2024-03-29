@extends('layouts.main')

@section('content')

    <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Users
                        <a href="{{url('register')}}" class="btn btn-primary">Add New</a>
                    </h6>
                </div>

        <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-pending" role="tabpanel" aria-labelledby="nav-pending-tab">
                <div class="card-body">
                    <div class="table-responsive">
                        <p id="msg" class="alert d-none"></p>
                        @if($users->count() > 0)
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Domain</th>
                                    <th>Domain Name</th>
                                    <th>Email Address</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                
                                <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{$user->domain}}</td>
                                    <td class="change-field">
                                        <span class="domain-name">{{$user->domain_name}}</span>
                                        <input type="hidden" name="domain_name" value="{{$user->domain_name}}" /> 
                                    </td>
                                    <td class="change-field">
                                        <span class="email">{{$user->email}}</span>
                                        <input type="hidden" name="email" value="{{$user->email}}" /> 
                                    </td>
                                    <td>
                                        <button class="btn btn-warning edit-action" data-edit="0" data-id="{{$user->id}}">Edit</button>
                                    </td>
                                </tr>
                                @endforeach          
                                </tbody>
                            </table>
                        @else
                            <p>No User has been added at this point</p>
                        @endif
                    </div>
                </div>
                </div>

        </div>

    </div>
                                
@stop

@section('js')
    <script type="application/javascript">
        $('.edit-action').click(function() {
            let edit = $(this).data('edit');
            if(edit==0) {
                $(this).data('edit', 1);
                $(this).removeClass('btn-warning');
                $(this).addClass('btn-success');
                $(this).html('Save');
                $('.change-field').each(function() {
                    $(this).children('span').addClass('d-none');
                    $(this).children('input').attr('type', 'text');
                })
            }else{
                var domain_name = $('input[name=domain_name]').val();
                var email = $('input[name=email]').val();
                var id = $(this).data('id');
                var url = "{{url('update_user')}}";
                var token = $('meta[name="csrf-token"]').attr('content');
                var formData =  {id, domain_name, email, _token: token};
                var state = $(this);
                axios.post(url, formData)
                .then((res) => {
                    console.log(res.data);
                    $('.change-field').each(function() {
                        $(this).children('.domain-name').html(domain_name);
                        $(this).children('input[name=domain_name]').val(domain_name);
                        $(this).children('.email').html(email);
                        $(this).children('input[name=email]').val(email);
                    })
                })
                $(this).data('edit', 0);
                $(this).removeClass('btn-success');
                $(this).addClass('btn-warning');
                $(this).html('Edit');
                $('.change-field').each(function() {
                    $(this).children('span').removeClass('d-none');
                    $(this).children('input').attr('type', 'hidden');
                })
            }
        })



        $('.activateToggle').click(function() {
            //message('An Error occured while attempting to perform your operation', false);
            var active = ($(this).data('active')==1) ? 0 : 1;
            var id = $(this).data('id');
            var url = "{{url('admin/toggle_account')}}";
            var token = $('meta[name="csrf-token"]').attr('content');
            var formData =  {id, active, _token: token};

            var span = $(this).parent().siblings().find('span');
            var msg = '';
            
            axios.post(url, formData)
            .then((res) => {
                console.log(res.data);
                $(this).data('active', active);
                
                if(active==1) {
                    $(this).removeClass('btn-success');
                    $(this).addClass('btn-danger');
                    $(this).html('Deactivate');
                    span.html('ACTIVE');
                    span.removeClass('alert-danger');
                    span.addClass('alert-success');
                    msg = 'Account Activated Successfully';
                }
                if(active==0) {
                    $(this).removeClass('btn-danger');
                    $(this).addClass('btn-success');
                    $(this).html('Activate');
                    span.html('INACTIVE');
                    span.removeClass('alert-success');
                    span.addClass('alert-danger');
                    msg = 'Account Deactivated Successfully';
                }
                message(msg, true);
            })
            .catch((error) => {
                console.log("An error occured while trying to perform the operation "+error.message);
                message('An Error occured while attempting to perform your operation', false);
                throw error;
            });
            setInterval(()=>{  
                clearMessage();
            }, 5000);
        })

        function message(msg, success)
        {
            if(success) {
                $('#msg').addClass('alert-success');
            }else{
                $('#msg').addClass('alert-danger');
            }
            $('#msg').html(msg);
            $('#msg').removeClass('d-none');
        }
        function clearMessage()
        {
            $('#msg').removeClass('alert-success');
            $('#msg').removeClass('alert-danger');
            $('#msg').addClass('d-none');
        }
    </script>
@stop


