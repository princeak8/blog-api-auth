     
  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="{{url('/logout')}}">Logout</a>
        </div>
      </div>
    </div>
  </div>

<!-- Bootstrap core JavaScript-->
<script src="{{asset('assets/vendors/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/vendors/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('assets/ckeditor5/ckeditor.js')}}"></script>

<!-- Core plugin JavaScript-->
<script src="{{asset('assets/vendors/jquery-easing/jquery.easing.min.js')}}"></script>

<!-- Custom scripts for all pages-->
<script src="{{asset('assets/js/sb-admin-2.min.js')}}"></script>  

  <!-- Page level plugins -->
<!--<script src="{{asset('assets/vendors/chart.js/Chart.min.js')}}"></script>-->
  
  <!-- Page level custom scripts -->
<!--<script src="{{asset('assets/js/demo/chart-area-demo.js')}}"></script>  
<script src="{{asset('assets/js/demo/chart-pie-demo.js')}}"></script> -->
<script src="{{asset('assets/js/vue.js')}}"></script>  
<script src="{{asset('assets/js/axios.min.js')}}"></script>  
<script type="application/javascript">
    $('.accordion-button').click(function() {
        let open = $(this).data('open');
        let id = $(this).data('id');
        console.log(open);
        if(open) {
            $('#'+id).css('display', 'none');
        }else{
            $('#'+id).css('display', 'block');
        }
        $(this).data('open', !open);
    })

    $(function() {
        $('nav a[href^="/' + location.pathname.split("/")[1] + '"]').addClass('active');
    });
    

</script>
@yield('js')
