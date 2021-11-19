<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{__('blog.title_website')}} | {{__('lang.dashboard')}}</title>
  <link rel="icon" type="image/png" href="{{asset('images/logo.png')}}"/>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('admin/plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="{{asset('admin/plugins/flag-icon-css/css/flag-icon.min.css')}}">
  
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">

  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('admin/plugins/summernote/summernote-bs4.min.css')}}">

  <!-- Toastr -->
  <link rel="stylesheet" href="{{asset('admin/plugins/toastr/toastr.min.css')}}">

  <!-- flag-icon-css -->
  <link rel="stylesheet" href="{{asset('admin/plugins/flag-icon-css/css/flag-icon.min.css')}}">
  <link rel="stylesheet" href="{{asset('admin/plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

  <link rel="stylesheet" href="{{asset('admin/dist/css/adminlte.min.css')}}">
  <link href="{{asset('css/sidebars.css')}}" rel="stylesheet">

  <style>
    nav svg{
      height: 20px;
    }
    @font-face{
      font-family: Phetsarath OT;
      src: url('{{asset('fonts/PhetsarathຫOT.ttf')}}');
    }
  </style>

  @livewireStyles

</head>
<body class="hold-transition layout-top-nav" style="font-family: 'Phetsarath OT'">
<div class="wrapper">

  <!-- Navbar -->
  @include('layouts.settings.navmenuapp-setting')
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    @yield('content')

  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Version 1.0.0
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2009 - @php
        echo date('Y')
    @endphp <a href="https://citgroup.la" target="_blank">ບໍລິສັດ ຊີໄອທີ ຈຳກັດຜູດຽວ</a>.</strong>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('admin/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- DataTables  & Plugins -->
<script src="{{asset('admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('admin/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('admin/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('admin/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

<!-- AdminLTE App -->

<script src="{{asset('admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
<script src="{{asset('admin/plugins/raphael/raphael.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-mapael/jquery.mapael.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-mapael/maps/usa_states.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('admin/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- Select2 -->
<script src="{{asset('admin/plugins/select2/js/select2.full.min.js')}}"></script>

<!-- Toastr -->
<script src="{{asset('admin/plugins/toastr/toastr.min.js')}}"></script>
<!-- Bootstrap Switch -->
<script src="{{asset('admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>

<!-- AdminLTE App -->
<script src="{{asset('admin/dist/js/adminlte.min.js')}}"></script>
<script src="{{asset('js/sidebars.js')}}"></script>
<script src="{{asset("js/money.format.js")}}"></script>
<!--<script src="{{asset("ckeditor/ckeditor.js")}}"></script>-->
<script src="https://cdn.ckeditor.com/ckeditor5/28.0.0/classic/ckeditor.js"></script>


<script>
  $(function () {

    // Summernote
    $('.summernote').summernote()

    $('.select2').select2()

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["excel", "print"]
      //"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

<script type="text/javascript">
  @if(Session::has('success'))
      toastr.options.positionClass = 'toast-bottom-right';
      toastr.success("{{Session::get('success') }}")
  @elseif(Session::has('warning'))
      toastr.options.positionClass = 'toast-bottom-right';
      toastr.warning("{{Session::get('warning')}}")
  @elseif(Session::has('error'))
      toastr.options.positionClass = 'toast-bottom-right';
      toastr.error("{{Session::get('error')}}")
  @endif
</script>

<!--
<script>
  window.livewire.on('alert', param => {
        toastr[param['type']](param['message'],param['type']);
  });
</script>
-->

@yield('scripts')


</body>
</html>
