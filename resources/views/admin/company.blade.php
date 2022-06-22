@extends('layouts/admin')

@section('content')

 <!-- Begin Page Content -->
 <div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary btn-sm px-1 py-1">Company Information and Policies</h6>
        </div>
        <div class="card-body">
            <p id="err" class="col-12 alert alert-danger d-none"></p>
            <div id="contact">
                <div id="address" class="mt-4">
                    <h4 class="mr-5">Company Name</h4>
                    <p class="mr-5 m-0" id="name-field">{{$company->name}}</p>
                    <input type="text" id="name-input" class="form-control input d-none" value="{{$company->name}}" />
                    <button type="button" data-field="name" data-edit="false" class="btn btn-warning btn-sm px-1 py-1 edit">Edit</button>
                    <button type="button" data-field="name" id="name-cancel" class="btn btn-danger btn-sm px-1 py-1 cancel d-none">Cancel</button>
                </div>
                <div id="address" class="mt-4">
                    <h4 class="mr-5">Office Address</h4>
                    <p class="m-0" id="address-field">{{$company->address}}</p>
                    <input type="text" id="address-input" class="form-control input d-none" value="{{$company->address}}" />
                    <button type="button" data-field="address" data-edit="false" class="btn btn-warning btn-sm px-1 py-1 edit">Edit</button>
                </div>
                <div id="phone" class="mt-4">
                    <h4 class="mr-5">Phone Numbers</h4>
                    <p class="m-0" id="phone_numbers-field">{{$company->phone_numbers}}</p>
                    <input type="text" id="phone_numbers-input" class="form-control input d-none" value="{{$company->phone_numbers}}" />
                    <button type="button" data-field="phone_numbers" data-edit="false" class="btn btn-warning btn-sm px-1 py-1 edit">Edit</button>
                </div>
                <div id="email" class="mt-4">
                    <h4 class="mr-5">Email Address</h4>
                    <p class="m-0" id="email-field">{{$company->email}}</p>
                    <input type="text" id="email-input" class="form-control input d-none" value="{{$company->email}}" />
                    <button type="button" data-field="email" data-edit="false" class="btn btn-warning btn-sm px-1 py-1 edit">Edit</button>
                </div>
            </div>
            <div class="accordion" id="accordionParent">
                
                <div class="row accordion-item">
                    <div class="col-md-12">
                        <div class="divider divider-left-center">
                            <div class="divider-text">
                                <h2 class="accordion-header" id="headingAbout">
                                    <!--<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#about" aria-expanded="true" aria-controls="about">-->
                                    <button class="accordion-button btn btn-primary" data-id="about" type="button" data-open="false">
                                        About
                                    </button>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div><!-- Accordion-Item -->

                <div id="about" class="row accordion-collapse collapse" aria-labelledby="headingAbout">
                    <div class="accordion-body">
                        <p id="about-field" class="col-12">{{strip_tags($company->about)}}</p>
                        <div id="about-input" class="d-none col-12">
                            <textarea id="about-area" class="form-control input"> {{$company->about}} </textarea>
                        </div>
                        <button type="button" data-field="about" data-edit="false" class="btn btn-warning btn-sm px-1 py-1 edit">Edit</button>
                        <button type="button" data-field="about" data-edit="false" id="about-cancel" class="btn btn-danger btn-sm px-1 py-1 cancel d-none">Cancel</button>
                    </div>
                </div>
                <!-- End of about  -->

                <div class="row accordion-item">
                    <div class="col-md-12">
                        <div class="divider divider-left-center">
                            <div class="divider-text">
                                <h2 class="accordion-header" id="headingReturnPolicy">
                                    <button class="accordion-button btn btn-primary" data-id="returnPolicy" type="button" data-open="false">
                                        Return Policy
                                    </button>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div><!-- Accordion-Item -->

                <div id="returnPolicy" class="row accordion-collapse collapse" aria-labelledby="headingReturnPolicy">
                    <div class="row accordion-body">
                            <p id="return_policy-field" class="col-12">{{strip_tags($company->return_policy)}}</p>
                            <div id="return_policy-input" class="d-none col-12">
                                <textarea id="return_policy-area" class="form-control input"> {{$company->return_policy}} </textarea>
                            </div>
                            <button type="button" data-field="return_policy" data-edit="false" class="btn btn-warning btn-sm px-1 py-1 edit">Edit</button>
                            <button type="button" data-field="return_policy" data-edit="false" id="return_policy-cancel" class="btn btn-danger btn-sm px-1 py-1 cancel d-none">Cancel</button>
                    </div>
                </div>
                <!-- End of Return Policy  -->

                <div class="row accordion-item">
                    <div class="col-md-12">
                        <div class="divider divider-left-center">
                            <div class="divider-text">
                                <h2 class="accordion-header" id="headingDeliveryPolicy">
                                    <button class="accordion-button btn btn-primary" data-id="deliveryPolicy" type="button" data-open="false">
                                    Delivery Policy
                                    </button>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div><!-- Accordion-Item -->

                <div id="deliveryPolicy" class="row accordion-collapse collapse" aria-labelledby="headingDeliveryPolicy">
                    <div class="row accordion-body">
                        <p id="delivery_policy-field" class="col-12">{{strip_tags($company->delivery_policy)}}</p>
                        <div id="delivery_policy-input" class="d-none col-12">
                            <textarea id="delivery_policy-area" class="form-control input"> {{$company->delivery_policy}} </textarea>
                        </div>
                        <button type="button" data-field="delivery_policy" data-edit="false" class="btn btn-warning btn-sm px-1 py-1 edit">Edit</button>
                        <button type="button" data-field="delivery_policy" data-edit="false" id="delivery_policy-cancel" class="btn btn-danger btn-sm px-1 py-1 cancel d-none">Cancel</button>
                    </div>
                </div>
                <!-- End of Delivery Policy  -->

                <div class="row accordion-item">
                    <div class="col-md-12">
                        <div class="divider divider-left-center">
                            <div class="divider-text">
                                <h2 class="accordion-header" id="headingFaq">
                                    <button class="accordion-button btn btn-primary" data-id="faq" type="button" data-open="false">
                                        FAQ
                                    </button>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div><!-- Accordion-Item -->

                <div id="faq" class="row accordion-collapse collapse" aria-labelledby="headingFaq">
                    <div class="row accordion-body">
                        <p id="faq-field" class="col-12">{{strip_tags($company->faq)}}</p>
                        <div id="faq-input" class="d-none col-12">
                            <textarea id="faq-area" class="form-control input"> {{$company->faq}} </textarea>
                        </div>
                        <button type="button" data-field="faq" data-edit="false" class="btn btn-warning btn-sm px-1 py-1 edit">Edit</button>
                        <button type="button" data-field="faq" data-edit="false" id="faq-cancel" class="btn btn-danger btn-sm px-1 py-1 cancel d-none">Cancel</button>
                    </div>
                </div>
                <!-- End of FAQ  -->

            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@stop

@section('js')
    <script type="application/javascript">
        //console.log(ClassicEditor);
        /*tinymce.init({
            selector: 'textarea'
        });*/
        $('textarea').each(function() {
            var id = $(this).attr('id');
            let newStr = id.split('-');
            var field = newStr[0];
            //console.log(id);
            ClassicEditor.create( document.querySelector( '#'+id ) )
            .then( editor => {
                window[field+'Editor'] = editor;
                //console.log( 'editor: ',editor );
            } )
            .catch( error => {
                console.error( error );
            } );
        })
        
        $(document).ready(function() {
            
            $('.input').each(function() {
                var id = $(this).attr('id');
                //console.log(id);
                let newStr = id.split('-');
                var field = newStr[0];
                var currentEditor = window[field+'Editor'];
                if(typeof currentEditor === 'undefined') {
                    var val = $('#'+field+'-input').val();
                }else{
                    var val = currentEditor.getData();
                }
                if(val.trim() == '') {
                    $('#'+field+'-field').addClass('d-none');
                    $('#'+field+'-input').removeClass('d-none');
                    $(this).siblings('button').removeClass('btn-warning');
                    $(this).siblings('button').addClass('btn-primary');
                    $(this).siblings('button').data('edit', 'true');
                }else{
                   //console.log($(this).val().trim()); 
                }
                //console.log($(this).val());
            })
            $('.cancel').click(function() {
                var field = $(this).data('field');
                //$('#'+field+'-input').val('');
                $('#'+field+'-input').addClass('d-none');
                $('#'+field+'-field').removeClass('d-none');
                $(this).siblings('button').removeClass('btn-primary');
                $(this).siblings('button').addClass('btn-warning');
                $(this).siblings('button').html('Edit');
                $(this).siblings('button').data('edit', false);
                $(this).addClass('d-none');
            })
            $('.edit').click(function() {
                
                //console.log('edit');
                var field = $(this).data('field');
                //console.log(field);
                var edit = $(this).data('edit');
                //console.log('edit: ',edit);
                if(!edit) { //it is currently not in edit mode, change to edit mode
                    $('#'+field+'-field').addClass('d-none');
                    $('#'+field+'-input').removeClass('d-none');
                    $('#'+field+'-cancel').removeClass('d-none');
                    $(this).removeClass('btn-warning');
                    $(this).addClass('btn-primary');
                    $(this).html('Save');
                }else{
                    var currentEditor = window[field+'Editor'];
                    //console.log('value', currentEditor.getData());
                    if(typeof currentEditor === 'undefined') {
                        //console.log('not a textarea')
                        var val = $('#'+field+'-input').val();
                    }else{
                        //console.log('textarea');
                        var val = currentEditor.getData();
                    }
                    
                    if(val.trim()=='') {
                        $('#err').html('Field cannot be empty');
                        $('#err').removeClass('d-none');
                        setInterval(()=>{ 
                            $('#err').html('');
                            $('#err').addClass('d-none');
                        }, 7000);
                    }else{
                        console.log('updating..');
                        var url = "{{url('admin/company/update_field')}}";
                        var formData =  {field:field, val: val};
                        //var self = $(this);
                        //console.log(photoId);
                        axios.post(url, formData)
                        .then((res) => {
                            console.log('status: ',res.data.status);
                            if(res.data.statusCode == 200) {
                                $('#'+field+'-field').html(val);
                                $('#'+field+'-input').val(val);
                                $('#'+field+'-input').addClass('d-none');
                                $('#'+field+'-cancel').addClass('d-none');
                                $('#'+field+'-field').removeClass('d-none');
                                $(this).removeClass('btn-primary');
                                $(this).addClass('btn-warning');
                                $(this).html('Edit');
                            }else{
                                $('#err').html(res.data.msg);
                                $('#err').removeClass('d-none');
                                setInterval(()=>{ 
                                    $('#err').html('');
                                    $('#err').addClass('d-none');
                                }, 7000); 
                            }
                        })
                        .catch((error) => {
                            $('#err').html('An error occured while trying to perform the operation');
                            $('#err').removeClass('d-none');
                            setInterval(()=>{ 
                                $('#err').html('');
                                $('#err').addClass('d-none');
                            }, 7000);
                            console.log("An error occured while trying to perform the operation "+error.message);
                            throw error;
                        });
                    }
                }
                $(this).data('edit', !edit);
            })
        })
    </script>
@stop
