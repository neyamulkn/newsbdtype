    <script src="{{asset('backend')}}/assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap popper Core JavaScript -->
    <script src="{{asset('backend')}}/assets/node_modules/popper/popper.min.js"></script>
    <script src="{{asset('backend')}}/assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{asset('backend')}}/dist/js/perfect-scrollbar.jquery.min.js"></script>
    <!--Wave Effects -->
    <script src="{{asset('backend')}}/dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="{{asset('backend')}}/dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="{{asset('backend')}}/dist/js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!--morris JavaScript -->
    <script src="{{asset('backend')}}/assets/node_modules/raphael/raphael-min.js"></script>
    <script src="{{asset('backend')}}/assets/node_modules/morrisjs/morris.min.js"></script>
    <script src="{{asset('backend')}}/assets/node_modules/jquery-sparkline/jquery.sparkline.min.js"></script>
    <!-- Popup message jquery -->
    <script src="{{asset('backend')}}/dist/js/toastr.js"></script>

    {!! Toastr::message() !!}
    <script>
        @if($errors->any())
        @foreach($errors->all() as $error)
        toastr.error("{{ $error }}");
        @endforeach
        @endif
    </script>
    @yield('js')

    @if(Auth::check()) 
    <script>

        function readNotify(id){
            
            var url = "{{route('readNotify', ':id')}}";
            url = url.replace(":id", id);
            $.ajax({
                url:url,
                method:"get",
            });
        }

    </script>
    @endif
