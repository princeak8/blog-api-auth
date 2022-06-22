@extends('layouts/admin')

@section('content')

    <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Bank Accounts
                        <a href="{{url('admin/add_bank_account')}}" class="btn btn-primary">Add New</a>
                    </h6>
                </div>

        <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-pending" role="tabpanel" aria-labelledby="nav-pending-tab">
                <div class="card-body">
                    <div class="table-responsive">
                        <p id="msg" class="alert d-none"></p>
                        @if($bankAccounts->count() > 0)
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Bank Name</th>
                                    <th>Account Name</th>
                                    <th>Account Number</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                
                                <tbody>
                                @foreach($bankAccounts as $bankAccount)
                                <tr>
                                    <td>{{$bankAccount->bank->name}}</td>
                                    <td>{{$bankAccount->name}}</td>
                                    <td>{{$bankAccount->number}}</td>
                                    <td>
                                        <span class="@if($bankAccount->active==1) alert-success @else alert-danger @endif">
                                            @if($bankAccount->active==1) ACTIVE @else INACTIVE @endif
                                        </span>
                                    </td>
                                    <td>
                                        <button 
                                            class="btn @if($bankAccount->active==1) btn-danger @else btn-success @endif activateToggle" 
                                            data-active="{{$bankAccount->active}}" data-id="{{$bankAccount->id}}"
                                        >
                                            @if($bankAccount->active==1) Deactivate @else Activate @endif
                                        </button>
                                        <a href="{{url('admin/edit_bank_account/'.$bankAccount->id)}}" class="btn btn-primary">Edit</a>
                                    </td>
                                </tr>
                                @endforeach          
                                </tbody>
                            </table>
                        @else
                            <p>No Bank Account has been added at this point</p>
                        @endif
                    </div>
                </div>
                </div>

        </div>

    </div>
                                
@stop

@section('js')
    <script type="application/javascript">
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


