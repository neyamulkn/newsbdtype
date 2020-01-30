@extends('backend.layouts.master')
@section('title', 'Manage news')
@section('css')
   
    <link rel="stylesheet" type="text/css"
        href="{{asset('backend/assets')}}/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">

@endsection
@section('content')
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor">Manage News </h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">

                            <a href="{{route('news.create')}}" class="btn btn-info d-none d-lg-block m-l-15"><i
                                    class="fa fa-plus-circle"></i> Create New</a>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Title</th>
                                                <th>Category<br/>Subcategory</th>
                                                <th>Author</th>
                                                <th>Publish Date</th>
                                                <th>Total View</th>
                                                @if(Auth::user()->role_id != env('GENERAL_REPORTER'))
                                                <th>Breaking News</th>
                                                <th>Status</th>
                                                @endif
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=1;?>
                                            @foreach($get_news as $show_news)
                                            <tr id="item{{$show_news->id}}">
                                               <td><img src="{{asset('upload/images/thumb_img/'.$show_news->source_path)}}" width="100"></td>
                                                <td><a href="{{route('news_details', $show_news->news_slug)}}" target="_blank">{{str_limit($show_news->news_title, 20)}}</a> </td>
                                                <td>{{$show_news->category_bd}} <br/>
                                                    {{$show_news->subcategory_bd}}
                                                </td>
                                                <td><a href="{{route('reporter_details', $show_news->username)}}" target="_blank">{{$show_news->name}}</a></td>

                                                <td>{{Carbon\Carbon::parse($show_news->created_at)->diffForHumans()}}</td>
                                                <td> {{$show_news->view_counts}}</td>
                                                 @if(Auth::user()->role_id != env('GENERAL_REPORTER'))
                                                <td>
                                                    <div class="custom-control custom-switch" style="padding-left: 3.25rem;">
                                                      <input name="breaking_news" onclick="breaking_news({{$show_news->id}})"  type="checkbox" {{($show_news->breaking_news == 1) ? 'checked' : ''}} class="custom-control-input" id="breaking{{$show_news->id}}">
                                                      <label class="custom-control-label" for="breaking{{$show_news->id}}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-switch" style="padding-left: 3.25rem;">
                                                      <input name="status" onclick="satusActiveDeactive({{$show_news->id}})"  type="checkbox" {{($show_news->status == 1) ? 'checked' : ''}} class="custom-control-input" id="status{{$show_news->id}}">
                                                      <label class="custom-control-label" for="status{{$show_news->id}}"></label>
                                                    </div>
                                                </td>
                                                @endif
                                                <td>
                                                    <a  href="{{route('news.edit', $show_news->news_slug)}}"   title="Edit" class="btn btn-info btn-sm"><i class="ti-pencil" aria-hidden="true"></i> </a>
                                                    <button data-target="#delete" title="Delete" onclick="confirmPopup('{{ $show_news->id }}')" class="btn btn-danger btn-sm" data-toggle="modal"><i class="ti-trash" aria-hidden="true"></i> </button>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                     <span style="float: right;">{{$get_news->links()}}</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->

                  <!-- delete Modal -->
        <div id="delete" class="modal fade">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="icon-box">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <h4 class="modal-title">Are you sure?</h4>
                        <p>Do you really want to delete these records? This process cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                        <button type="button" value="" id="itemID" onclick="deleteItem(this.value)" data-dismiss="modal" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('js')
    <!-- This is data table -->
    
    <script src="{{asset('backend/assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>

    <!-- end - This is for export functionality only -->
    <script>
        $(function () {
            $('#myTable').DataTable();
            var table = $('#example').DataTable({
                "columnDefs": [{
                    "visible": false,
                    "targets": 2
                }],
                "order": [
                    [2, 'asc']
                ],
                "displayLength": 25,
                "drawCallback": function (settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(2, {
                        page: 'current'
                    }).data().each(function (group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                            last = group;
                        }
                    });
                }
            });


        });

    </script>

    <script type="text/javascript">

        function satusActiveDeactive(id){

            var  url = '{{route("news.status", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data.status == 'publish'){
                        toastr.success(data.message);
                    }else{
                        toastr.error(data.message);
                    }
                }
            });
        }
        function breaking_news(id){

            var  url = '{{route("breaking_news", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data.status == 'added'){
                        toastr.success(data.message);
                    }else{
                        toastr.error(data.message);
                    }
                }
            });
        }

        function edit(id){
            var  url = '{{route("news.edit", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#edit_form").html(data);
                }
            }

        });

    }

    function confirmPopup(id) {
        document.getElementById('itemID').value = id;
    }

    function deleteItem(id) {

            var link = '{{route("news.delete", ":id")}}';
            var link = link.replace(':id', id);
                $.ajax({
                url:link,
                method:"get",
                success:function(data){
                    if(data){
                        $("#item"+id).hide();
                        toastr.error(data);
                    }
                }

            });
        }

</script>
@endsection
