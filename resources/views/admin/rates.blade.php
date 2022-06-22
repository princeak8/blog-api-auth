@extends('layouts/admin')

@section('content')

    <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Currency Rates
                    </h6>
                </div>

        <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-pending" role="tabpanel" aria-labelledby="nav-pending-tab">
                <div class="card-body">
                    <div class="table-responsive">
                        <p id="msg" class="alert d-none"></p>
                        @if($rates->count() > 0)
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Currency</th>
                                    <th>Rate</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                
                                <tbody>
                                @foreach($rates as $rate)
                                    <tr>
                                        <td>{{$rate->currency->name}}</td>
                                        <td>
                                            <span>{{$rate->rate}}</span>
                                            <input type="text" name="rate" value="{{$rate->rate}}" class="d-none" />
                                        </td>
                                        <td>
                                            <button class="btn btn-primary change" data-action="0" data-id="{{$rate->id}}">Change</button>
                                        </td>
                                    </tr>
                                @endforeach          
                                </tbody>
                            </table>
                        @else
                            <p>Something is wrong</p>
                        @endif
                    </div>
                </div>
                </div>

        </div>

    </div>
                                
@stop

@section('js')
    <script type="application/javascript">
        $('.change').click(function() {
            //Determine whether its set to update the change or show the input element to make the change
            var action = ($(this).data('action')==1) ? true : false;

            //Set the action value appropriately; i.e 1=making a change 0=displaying the input element
            (action) ? $(this).data('action', 0) : $(this).data('action', 1);
            
            //Get the id of the rate
            var id = $(this).data('id');

            //Get the input element and the span 
            var input = $(this).parent().siblings().find('input');
            var span = $(this).parent().siblings().find('span');

            if(!action) {
                //If it is just preparing for a update, remove the span and show the input element
                $(this).removeClass('btn-primary');
                $(this).addClass('btn-success');
                $(this).html('Save');
                span.addClass('d-none'); input.removeClass('d-none');
            }

            if(action) {
                //If it is actually making a change, i.e the save button has been clicked
                var button = $(this);
                var rate = input.val();
                $(this).prop('disabled', true);
                console.log('val', rate);
                var msg = '';
                if(!isNaN(rate)) {
                    var url = "{{url('admin/update_rate')}}";
                    var token = $('meta[name="csrf-token"]').attr('content');
                    var formData =  {id, rate, _token: token};
                    
                    axios.post(url, formData)
                    .then((res) => {
                        console.log(res.data);
                        message('rate updated successfully', true);
                        button.removeClass('btn-success');
                        button.addClass('btn-primary');
                        button.html('Change');
                        span.html(rate);
                        input.addClass('d-none'); span.removeClass('d-none');
                    })
                    .catch((error) => {
                        console.log("An error occured while trying to perform the operation "+error.message);
                        message('An Error occured while attempting to perform your operation', false);
                        throw error;
                    });
                }else{
                    console.log('not a number');
                    message('Rate must be a number', false);
                }
                setInterval(()=>{  
                        clearMessage();
                }, 5000);
            }
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


