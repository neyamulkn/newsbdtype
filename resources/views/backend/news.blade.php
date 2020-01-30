@extends('backend.layouts.master')
@section('title', 'Add posts')
@section('css')
    <link rel="stylesheet" href="{{asset('backend/assets')}}/node_modules/html5-editor/bootstrap-wysihtml5.css">
    <link href="{{asset('backend/assets')}}/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
    <link href="{{asset('backend')}}/dist/css/gallery.css" rel="stylesheet">
    <!-- Date picker plugins css -->
    <link href="{{asset('backend/assets')}}/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/assets')}}/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend')}}/dist/css/pages/tab-page.css" rel="stylesheet" type="text/css" />
     <script src="https://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>

    <style>

        .page-titles {
            margin: 0 -25px 5px !important;
        }
        .dropify-wrapper{
            margin-bottom: 10px;
        }
        .dropify_image_area{
            position: absolute;top: -14px;left: 12px;background:#fff;padding: 3px;
        }
        .bootstrap-tagsinput{
            width: 100% !important;
            padding: 5px;
        }
        #image .dropify-wrapper, #video .dropify-wrapper {
            height: 18rem !important;
        }
        .news-type label{position: initial !important;cursor: pointer !important}

        .news-type input{display: none; }
        .news-type  .active{
            background: #fb9678;
            color: #fff;
            padding: 6px;
            border-radius: 3px;
        }

        .attach-file-box{
            position: relative;
            padding: 15px;
            border: 1px solid #e1e1e1;
            margin: 15px 0px;
        }

    </style>
@endsection

@section('content')

    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h4 class="text-themecolor">বাংলার খবর তৈরি করুন </h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <a href="{{route('news.list')}}" class="btn btn-info btn-sm d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> News List</a>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->

            <div class="card">
                <div class="card-body">
                    <form action="{{route('news.store')}}" enctype="multipart/form-data" class="floating-labels" method="post" id="news">
                        @csrf

                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-9 divrigth_border">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="news_title">সংবাদ শিরোনাম লিখুন</label>
                                                <input type="text" onchange="getSlug(this.value)" value="{{old('news_title')}}"  name="news_title" required="" id="news_title" class="form-control" >
                                                <input type="hidden" name="lang" value="1">

                                            </div>
                                             <span id="news_slug"></span>
                                        </div>
                                       

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label style="background: #fff;top:-10px;z-index: 1" for="news_dsc">বিস্তারিত বাংলা লিখুন</label>
                                                <textarea name="news_dsc" class="form-control" id="news_dsc" rows="5">{{old('news_dsc')}}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div  style="margin-top: 20px; position:relative; padding: 15px; border: 1px solid #e1e1e1">
                                                <label class="dropify_image_area" style="top:-12px;">Keywords</label>

                                                 <div class="tags-default">
                                                    <input type="text" name="keywords[]"  data-role="tagsinput" placeholder="add tags" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 news-type">
                                            <div  style="margin-top: 20px; position:relative; padding: 15px; border: 1px solid #e1e1e1">
                                                <span class="dropify_image_area" style="top:-12px;">সংবাদের ধরন</span>
                                                <input type="radio" checked="checked" onclick="newsType( 'Standard')" value="1" name="type" id="Standard"><label for="Standard" class="active"><i class="fa fa-text-height" aria-hidden="true"></i> Standard</label>

                                                <input type="radio" onclick="newsType( 'Image')" value="2" name="type" id="Image"><label for="Image"><i class="fa fa-camera" aria-hidden="true"></i> Image</label>

                                                <input onclick="newsType( 'Video')" value="3" type="radio" name="type" id="Video"><label for="Video"><i class="fa fa-video" aria-hidden="true"></i> Video</label>

                                                <input type="radio" onclick="newsType( 'Audio')" value="4" name="type" id="Audio"><label for="Audio"><i class="fa fa-audio-description" aria-hidden="true"></i> Audio</label>
                                            </div>
                                        </div>

                                        <div class="col-md-12 attach-file-area"></div>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="category">Category</label>
                                                <select name="category" onchange="get_subcategory(this.value)" id="category" class="form-control custom-select">
                                                   <option value="0"></option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->id}}" {{ (old('category') == $category->id) ? 'selected' : '' }}>{{$category->category_bd}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                          
                                            <span id="subcategory"></span>
                                            <span id="getdistrict"></span>
                                            <span id="getupzilla"></span>

                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="datepicker-autoclose" class="control-label">Publish date</label>
                                                <input name="publish_date" value="{{old('publish_date') ? old('publish_date') : Carbon\Carbon::parse(now())->format('Y-m-d')}}" required id="datepicker-autoclose" type="text" class="form-control">
                                            </div>
                                        </div>


                                        <div class="col-md-12">
                                            <div class="head-label" data-toggle="modal" data-target="#image" data-whatever="@mdo">
                                                <span class="dropify_image_area">ছবি যুক্ত করুন</span>
                                                <span><input type="hidden" id="image_path" required="" value="{{old('phato')}}" name="image"></span>
                                                <div id="upload-image">
                                                    <div class="dropify-wrapper" style="border:none !important;height:50px">
                                                        <div class="dropify-message">
                                                            <span style="font-size: 1.5em" class="fa fa-plus-circle"></span>
                                                            <p>Click here to add a photo</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if(Auth::user()->role_id == 1)
                                        <div class="col-md-12">
                                           <div class="form-group">
                                                <label for="user_id">Reporter</label>
                                                <select required="" name="user_id"  id="user_id" class="form-control custom-select">
                                                    <option></option>
                                                    @foreach($reporters as $reporter)
                                                        <option value="{{$reporter->id}}" {{ ($reporter->id == old('user_id')) ? 'selected' : '' }}>{{$reporter->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @endif

                                        @if(Auth::user()->role_id != env('GENERAL_REPORTER'))
                                         <div class="col-md-12" >
                                            <div class="head-label">
                                                <label class="dropify_image_area" style="top:-12px;">Breaking News</label>
                                                <div  style="padding:0px 1px 13px 40px" >
                                                    <div class="custom-control custom-switch">
                                                      <input name="breaking_news"  type="checkbox" class="custom-control-input" {{ (old('breaking_news') == 'on') ? 'checked' : '' }} id="customSwitch1">
                                                      <label style="padding: 8px 15px;" class="custom-control-label" for="customSwitch1">ON/OFF</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12" >
                                            <div class="head-label">
                                                <label class="dropify_image_area" style="top:-12px;">News Publish Status</label>
                                                <div  style="padding:0px 1px 13px 40px;">
                                                    <div class="custom-control custom-switch">
                                                      <input name="status" {{ (old('status') == 'on') ? 'checked' : '' }} type="checkbox" class="custom-control-input" id="status">
                                                      <label style="padding: 8px 15px;" class="custom-control-label" for="status">Publish/Unpublish</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                      <!--   <div class="col-md-12">
                                            <div class="head-label" data-toggle="modal" data-target="#video" data-whatever="@mdo">
                                            <span class="dropify_image_area">Add Video</span>
                                                <span id="video_path"><input type="hidden" value="{{old('video')}}" required="" name="video"></span>
                                                <div id="upload-video">
                                                    <div class="dropify-wrapper" style="border:none !important;height:85px">
                                                        <div class="dropify-message">
                                                            <span style="font-size: 2em" class="fa fa-plus-circle"></span>
                                                            <p>Add Videos</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div> -->

                                    </div>
                                </div>

                            </div>
                        </div><hr>
                        <div class="form-actions pull-right">
                            <button type="submit"  name="submit" value="save" class="btn btn-success"> <i class="fa fa-save"></i> Post News</button>
                            <button type="submit"  name="submit" value="draft" class="btn btn-info"> <i class="fa fa-archive"></i> Save & draft</button>
                            <button type="reset" class="btn waves-effect waves-light btn-secondary">Cancel</button>
                        </div>
                    </form>
                </div>
                <div class="preloader">
                    <div class="loader">
                        <div class="loader__figure"></div>
                        <p class="loader__label">Please wait</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->

    <div class="modal bs-example-modal-lg" id="image" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#image-tab" role="tab"><i class="fa fa-cloud-upload" aria-hidden="true"></i> <span class="hidden-xs-down">Upload File</span></a> </li>
                            <li class="nav-item"> <a class="nav-link" onclick="imageGallery()" data-toggle="tab" href="#image-gallery" role="tab"><i class="fa fa-hdd-o" aria-hidden="true"></i> <span class="hidden-xs-down">Media Gallery</span></a> </li>
                       </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active" id="image-tab" role="tabpanel">
                                <form action="{{route('phato.upload')}}" id="imageUploadForm" method="post" class="floating-labels" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="upload-bar">
                                            <p id="message-image"></p>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-image" role="progressbar" aria-valuenow=""
                                                     aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                                    0%
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" id="upload-file">
                                            <input type="file" class="dropify" onchange="uploadselectImage()" required="required" accept="image/*" data-type='image' data-allowed-file-extensions="jpg png gif"  data-max-file-size="2M"  name="phato" id="input-file-events">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                       <button type="button" id="dismis" class="btn btn-info" data-dismiss="modal">Insert image</button>

                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane  p-20" id="image-gallery" role="tabpanel">
                               <form action="{{route('selectImage')}}" method="get" id="selectImage">
                                    <div class="row ">
                                        <div class="col-md-9 col-sm-8 col-8">
                                            <div class="row inner-scroll"  id="show-image"></div>
                                        </div>
                                        <div class="col-md-3 col-sm-4 col-4">
                                            <div id="show_image_details"></div>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-info">Insert image</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    <!-- video upload modal -->
    <div class="modal bs-example-modal-lg" id="video" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: 0px !important;">
                    <h4 class="modal-title" id="exampleModalLabel1">Upload Gallery Image</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#video-tab" role="tab"><i class="fa fa-cloud-upload" aria-hidden="true"></i> <span class="hidden-xs-down">Upload File</span></a> </li>
                        <li class="nav-item"> <a class="nav-link" onclick="videoGallery()" data-toggle="tab" href="#video-gallery" role="tab"><i class="fa fa-hdd-o" aria-hidden="true"></i> <span class="hidden-xs-down">Media Gallery</span></a> </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content tabcontent-border">
                        <div class="tab-pane active" id="video-tab" role="tabpanel">
                            <form action="{{route('video.upload')}}" id="videoUploadForm" method="post" class="floating-labels" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="upload-bar">
                                        <p id="message-video"></p>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-video" role="progressbar" aria-valuenow=""
                                                 aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                                0%
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="upload-file">
                                        <input type="file" class="dropify" onchange="uploadselectVideo()" accept="video/*" data-type='video' required="required" data-allowed-file-extensions="mpeg ogg mp4 webm 3gp mov flv avi wmv"   name="video" id="input-file-events">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="dismis-video" class="btn btn-info" data-dismiss="modal">Insert Video</button>

                                </div>
                            </form>
                        </div>
                        <div class="tab-pane  p-20"  id="video-gallery" role="tabpanel">

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
   
    <!-- Plugin JavaScript -->
    <script src="{{asset('backend/assets')}}/node_modules/moment/moment.js"></script>

    <script src="{{asset('backend/assets')}}/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Clock Plugin JavaScript -->
    <script src="{{asset('backend/assets')}}/node_modules/clockpicker/dist/jquery-clockpicker.min.js"></script>
    <!-- Color Picker Plugin JavaScript -->
    <script src="{{asset('backend/assets')}}/node_modules/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js"></script>
    <!-- Date Picker Plugin JavaScript -->
    <script src="{{asset('backend/assets')}}/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="{{asset('backend/assets')}}/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script src="{{asset('backend/assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>

    <script type="text/javascript">
        function getSlug(slug) {
            var  url = '{{route("news.slug", ":id")}}';
            url = url.replace(':id', slug);

            $.ajax({
                url:url,
                method:"get",
                data:{slug:slug},
                success:function(slug){
                    if(slug){
                        $('#news_slug').focus();
                        document.getElementById('news_slug').innerHTML = '<div class="form-group"><input disabled="" required="" type="text" value="'+slug+'" id="slugEdit" name="news_slug"  class="form-control" ><span class="news_slug" onclick="enable()">Edit slug</span></div>';
                    }else{
                        document.getElementById('news_slug').innerHTML = "";
                    }
                }
             });
        }

        function enable() {
           
            document.getElementById("slugEdit").disabled = false;
            $('#slugEdit').focus();
        }

        function get_subcategory(id=0){
            var  url = '{{route("get_subcategory", ":id")}}';
            url = url.replace(':id',id);

            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#subcategory").html(data);
                        $("#subcategory").focus();
                        document.getElementById('getdistrict').innerHTML = "";
                        document.getElementById('getupzilla').innerHTML = "";
                    }else{
                        document.getElementById('subcategory').innerHTML = "";
                        document.getElementById('getdistrict').innerHTML = "";
                        document.getElementById('getupzilla').innerHTML = "";
                    }
                }
            });
        }

        function get_district(id=0){
            var  url = '{{route("get_district", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#getdistrict").html(data);
                        $("#district").focus();
                        document.getElementById('getupzilla').innerHTML = "";
                    }else{
                        document.getElementById('getdistrict').innerHTML = "";
                        document.getElementById('getupzilla').innerHTML = "";
                    }
                }
            });
        }

        function get_upzilla(id=0){
            var  url = '{{route("get_upzilla", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#getupzilla").html(data);
                         $("#upzilla").focus();
                    }else{
                        $("#getupzilla").html('');
                    }
                }
            });
        }


    </script>
    <script type="text/javascript">
        $('.news-type label').click(function() {
            $(this).addClass('active').siblings().removeClass('active');
        });
        function newsType(name){
            if(name == 'Image'){
                $('.attach-file-area').html('<div class="attach-file-box"><span class="dropify_image_area">Add '+name+'</span><div class="row attach-file" ><div class="col-md-3" onclick="addField(\'image/*\')"><div class="dropify-wrapper" ><div class="dropify-message"><span style="font-size: 2em" class="fa fa-plus-circle"></span> <p>Add More '+name+'</p></div></div></div></div></div>');
            }else if(name == 'Video') {
                $('.attach-file-area').html('<div class="attach-file-box"><span class="dropify_image_area">Add '+name+'</span><div class="row attach-file" ><div class="col-md-3" onclick="addField(\'video/*\')"><div class="dropify-wrapper" ><div class="dropify-message"><span style="font-size: 2em" class="fa fa-plus-circle"></span> <p>Add More '+name+'</p></div></div></div></div></div>');

            }else if(name == 'Audio') {
                    $('.attach-file-area').html('<div class="attach-file-box"><span class="dropify_image_area">Add '+name+'</span><div class="row attach-file" ><div class="col-md-3" onclick="addField(\'audio/*\')"><div class="dropify-wrapper" ><div class="dropify-message"><span style="font-size: 2em" class="fa fa-plus-circle"></span> <p>Add More '+name+'</p></div></div></div></div></div>');

                }else{
                $('.attach-file-area').html('');
            }

        }

        var box = 1;

        function addField(accept){
            box++;
           $(".attach-file").prepend('<div class="col-md-3"><input type="file" multiple form="news" accept="'+accept+'"  name="attach_files[]" id="id_news_image'+box+'" /></div>');
            document.getElementById("id_news_image"+box).click();

            $("#id_news_image"+box).addClass('dropify');
            $('.dropify').dropify();
        }
    </script>

    <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();

        // Translated
        $('.dropify-fr').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                remove: 'Supprimer',
                error: 'Désolé, le fichier trop volumineux'
            }
        });

        // Used events
        var drEvent = $('#input-file-events').dropify();

        drEvent.on('dropify.beforeClear', function(event, element) {
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });

        drEvent.on('dropify.afterClear', function(event, element) {
            alert('File deleted');
        });

        drEvent.on('dropify.errors', function(event, element) {
            console.log('Has Errors');
        });

        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e) {
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
    });
    </script>


    <script>
    // MAterial Date picker
    $('#mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false });
    $('#timepicker').bootstrapMaterialDatePicker({ format: 'HH:mm', time: true, date: false });
    $('#date-format').bootstrapMaterialDatePicker({ format: 'dddd DD MMMM YYYY - HH:mm' });

    $('#min-date').bootstrapMaterialDatePicker({ format: 'DD/MM/YYYY HH:mm', minDate: new Date() });

    // Date Picker
    jQuery('.mydatepicker, #datepicker').datepicker();
    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true,
         format: 'yyyy-mm-dd'
    });
    jQuery('#date-range').datepicker({
        toggleActive: true
    });
    jQuery('#datepicker-inline').datepicker({
        todayHighlight: true
    });

// Enter form submit preventDefault for tags
    $(document).on('keyup keypress', 'form input[type="text"]', function(e) {
      if(e.keyCode == 13) {
        e.preventDefault();
        return false;
      }
    });

    </script>

    <script type="text/javascript" src="{{asset('backend/formjs/jquery.form.js')}}"></script>

    <script>
        function uploadselectImage(){
            $("#imageUploadForm").submit();
        }

        $(document).ready(function(){
            $('#imageUploadForm').ajaxForm({
                beforeSend:function(){
                    $('.loader-image').css('display', 'block');
                },
                uploadProgress:function(event, position, total, percentComplete)
                {
                    $('.progress-bar-image').text(percentComplete + '%');
                    $('.progress-bar-image').css('width', percentComplete + '%');
                },
                success:function(data)
                {
                    if(data.errors)
                    {
                        $('.progress-bar-image').text('0%');
                        $('.progress-bar-image').css('width', '0%');
                        $('#message-image').html('<span class="text-danger"><b>'+data.errors+'</b></span>');
                    }
                    if(data.success)
                    {
                        $('.progress-bar-image').text('Upload completed');
                        $('.progress-bar-image').css('width', '100%');
                        $('#message-image').html('');
                        $('#upload-image').html(data.image);
                        $('#image_path').val(data.success);
                        $('#dismis').click();
                        // $('#media-gallery').click();
                        $('.dropify').dropify();
                        // Used events
                        var drEvent = $('#input-file-events').dropify();

                        drEvent.on('dropify.beforeClear', function(event, element) {
                            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
                        });

                        drEvent.on('dropify.afterClear', function(event, element) {
                            alert('File deleted');
                        });

                        drEvent.on('dropify.errors', function(event, element) {
                            console.log('Has Errors');
                        });

                        var drDestroy = $('#input-file-to-destroy').dropify();
                        drDestroy = drDestroy.data('dropify')
                        $('#toggleDropify').on('click', function(e) {
                            e.preventDefault();
                            if (drDestroy.isDropified()) {
                                drDestroy.destroy();
                            } else {
                                drDestroy.init();
                            }
                        });
                    }
                }
            });

        });


   /// Select images

    $("#selectImage").submit(function(event){
        event.preventDefault();
         var  url = '{{route("selectImage")}}';
        $.ajax({
            url:url,
            type:'get',
            data:$(this).serialize(),
            success:function(data){
                if(data){
                   $('#upload-image').html(data.image);
                    $('#image_path').val(data.success);
                    $('#dismis').click();
                    // $('#media-gallery').click();
                    $('.dropify').dropify();
                    // Used events
                    var drEvent = $('#input-file-events').dropify();

                    drEvent.on('dropify.beforeClear', function(event, element) {
                        return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
                    });

                    drEvent.on('dropify.afterClear', function(event, element) {
                        alert('File deleted');
                    });

                    drEvent.on('dropify.errors', function(event, element) {
                        console.log('Has Errors');
                    });

                    var drDestroy = $('#input-file-to-destroy').dropify();
                    drDestroy = drDestroy.data('dropify')
                    $('#toggleDropify').on('click', function(e) {
                        e.preventDefault();
                        if (drDestroy.isDropified()) {
                            drDestroy.destroy();
                        } else {
                            drDestroy.init();
                        }
                    });
                }
            }
        });
    });

    /// image details

        function image_details(image, title){
           $('#show_image_details').html('<div class="head-label"><img class="image_info" src="<?php echo asset('upload/images/thumb_img') ?>/'+image+'"></div><label for="image_title">Image Title</label><textarea  name="image_title" id="image_title" class="form-control" >'+title+'</textarea>');
        }
    </script>


    <script>
        function uploadselectVideo(){
            $("#videoUploadForm").submit();
        }

        $(document).ready(function(){
            $('#videoUploadForm').ajaxForm({
                beforeSend:function(){
                    $('.loader-image').css('display', 'block');
                },
                uploadProgress:function(event, position, total, percentComplete)
                {
                    $('.progress-bar-video').text(percentComplete + '%');
                    $('.progress-bar-video').css('width', percentComplete + '%');
                },
                success:function(data)
                {
                    if(data.errors)
                    {
                        $('.progress-bar-video').text('0%');
                        $('.progress-bar-video').css('width', '0%');
                        $('#message-video').html('<span class="text-danger"><b>'+data.errors+'</b></span>');
                    }
                    if(data.success)
                    {
                        $('.progress-bar-video').text('Upload completed');
                        $('.progress-bar-video').css('width', '100%');
                        $('#message-video').html('');
                        $('#upload-video').html(data.image);
                        $('#video_path').html(data.success);
                         $('#dismis-video').click();
                        // $('#media-gallery').click();
                    }
                }
            });

        });
    </script>

    <script>

        function imageGallery() {
            var  url = '{{route("imageGallery")}}';
            $('#show-image').html('<div id="loading"></div>');
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#show-image").html(data);
                    }
                }
            });
        }

        function videoGallery() {
            var  url = '{{route("videoGallery")}}';
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#video-gallery").html(data);
                    }
                }
            });

        }
    </script>

    <script>
        CKEDITOR.replace( 'news_dsc', {
            height: 300,
            filebrowserUploadUrl: "{{route('phato.phato_uploadCKEditor', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
    </script>

@endsection

