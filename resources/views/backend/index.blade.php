@extends('backend.layouts.master')
@section('css')
    <!-- chartist CSS -->
    <link href="{{asset('backend')}}/assets/node_modules/morrisjs/morris.css" rel="stylesheet">
    <!-- Dashboard 1 Page CSS -->
    <link href="{{asset('backend')}}/dist/css/pages/dashboard1.css" rel="stylesheet">
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
                    <h4 class="text-themecolor">Dashboard</h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Info box -->
            <!-- ============================================================== -->
            <div class="card-group">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h3><i class="icon-screen-desktop"></i></h3>
                                        <p class="text-muted">TOTAL NEWS</p>
                                    </div>
                                    <div class="ml-auto">
                                        <h2 class="counter text-primary">{{$news}}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="progress">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 85%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h3><i class="icon-note"></i></h3>
                                        <p class="text-muted">TOTAL PENDING</p>
                                    </div>
                                    <div class="ml-auto">
                                        <h2 class="counter text-cyan">{{$pending_news}}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="progress">
                                    <div class="progress-bar bg-cyan" role="progressbar" style="width: 85%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h3><i class="icon-doc"></i></h3>
                                        <p class="text-muted">TOTAL REPORTERS</p>
                                    </div>
                                    <div class="ml-auto">
                                        <h2 class="counter text-purple">{{$reporters}}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="progress">
                                    <div class="progress-bar bg-purple" role="progressbar" style="width: 85%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h3><i class="icon-bag"></i></h3>
                                        <p class="text-muted">Total Category</p>
                                    </div>
                                    <div class="ml-auto">
                                        <h2 class="counter text-success">{{$category}}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 85%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Info box -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Over Visitor, Our income , slaes different and  sales prediction -->
            <!-- ============================================================== -->
            <div class="row">
                <!-- Column -->
                <div class="col-lg-8 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex m-b-40 align-items-center no-block">
                                <h5 class="card-title ">DAILY VISITORS</h5>
                                <div class="ml-auto">
                                    <ul class="list-inline font-12">
                                        <li><i class="fa fa-circle text-cyan"></i> Male</li>
                                        <li><i class="fa fa-circle text-primary"></i> Female</li>
                                        <li><i class="fa fa-circle text-purple"></i> Both</li>
                                    </ul>
                                </div>
                            </div>
                            <div id="morris-area-chart" style="height: 340px;"></div>
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <div class="col-lg-4 col-md-12">
                    <div class="row">
                        <!-- Column -->
                        <div class="col-md-12">
                            <div class="card bg-cyan text-white">
                                <div class="card-body ">
                                    <div class="row weather">
                                        <div class="col-6 m-t-40">
                                            <h3>&nbsp;</h3>
                                            <div class="display-4">73<sup>°F</sup></div>
                                            <p class="text-white">Dhaka</p>
                                        </div>
                                        <div class="col-6 text-right">
                                            <h1 class="m-b-"><i class="wi wi-day-cloudy-high"></i></h1>
                                            <b class="text-white">SUNNEY DAY</b>
                                            <p class="op-5">Dec 15</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                        <div class="col-md-12">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div id="myCarouse2" class="carousel slide" data-ride="carousel">
                                        <!-- Carousel items -->
                                        <div class="carousel-inner">
                                            <div class="carousel-item active">
                                                <h4 class="cmin-height">My Acting blown <span class="font-medium">Your Mind</span> and you also <br/>laugh at the moment</h4>
                                                <div class="d-flex no-block">
                                                    <span><img src="{{asset('backend')}}/assets/images/users/1.jpg" alt="user" width="50" class="img-circle"></span>
                                                    <span class="m-l-10">
                                                <h4 class="text-white m-b-0">Govinda</h4>
                                                <p class="text-white">Actor</p>
                                                </span>
                                                </div>
                                            </div>
                                            <div class="carousel-item">
                                                <h4 class="cmin-height">My Acting blown <span class="font-medium">Your Mind</span> and you also <br/>laugh at the moment</h4>
                                                <div class="d-flex no-block">
                                                    <span><img src="{{asset('backend')}}/assets/images/users/2.jpg" alt="user" width="50" class="img-circle"></span>
                                                    <span class="m-l-10">
                                                <h4 class="text-white m-b-0">Govinda</h4>
                                                <p class="text-white">Actor</p>
                                                </span>
                                                </div>
                                            </div>
                                            <div class="carousel-item">
                                                <h4 class="cmin-height">My Acting blown <span class="font-medium">Your Mind</span> and you also <br/>laugh at the moment</h4>
                                                <div class="d-flex no-block">
                                                    <span><img src="{{asset('backend')}}/assets/images/users/3.jpg" alt="user" width="50" class="img-circle"></span>
                                                    <span class="m-l-10">
                                                <h4 class="text-white m-b-0">Govinda</h4>
                                                <p class="text-white">Actor</p>
                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                </div>
            </div>
            @if(Auth::user()->role_id == 1)
            <!-- ============================================================== -->
            <!-- Comment - table -->
            <!-- ============================================================== -->
            <div class="row">
                <!-- ============================================================== -->
                <!-- Comment widgets -->
                <!-- ============================================================== -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Recent Comments</h5>
                        </div>
                        <!-- ============================================================== -->
                        <!-- Comment widgets -->
                        <!-- ============================================================== -->
                        <div class="comment-widgets">
                            <!-- Comment Row -->
                            <div class="d-flex no-block comment-row">
                                <div class="p-2"><span class="round"><img src="{{asset('backend')}}/assets/images/users/1.jpg" alt="user" width="50"></span></div>
                                <div class="comment-text w-100">
                                    <h5 class="font-medium">James Anderson</h5>
                                    <p class="m-b-10 text-muted">Lorem Ipsum is simply dummy text of the printing and type setting industry. Lorem Ipsum has beenorem Ipsum is simply dummy text of the printing and type setting industry.</p>
                                    <div class="comment-footer">
                                        <span class="text-muted pull-right">April 14, 2016</span> <span class="badge badge-pill badge-info">Pending</span> <span class="action-icons">
                                                <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
                                                <a href="javascript:void(0)"><i class="ti-check"></i></a>
                                                <a href="javascript:void(0)"><i class="ti-heart"></i></a>    
                                            </span>
                                    </div>
                                </div>
                            </div>
                            <!-- Comment Row -->
                            <div class="d-flex no-block comment-row border-top">
                                <div class="p-2"><span class="round"><img src="{{asset('backend')}}/assets/images/users/2.jpg" alt="user" width="50"></span></div>
                                <div class="comment-text active w-100">
                                    <h5 class="font-medium">Michael Jorden</h5>
                                    <p class="m-b-10 text-muted">Lorem Ipsum is simply dummy text of the printing and type setting industry. Lorem Ipsum has beenorem Ipsum is simply dummy text of the printing and type setting industry..</p>
                                    <div class="comment-footer">
                                        <span class="text-muted pull-right">April 14, 2016</span>
                                        <span class="badge badge-pill badge-success">Approved</span>
                                        <span class="action-icons active">
                                                <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
                                                <a href="javascript:void(0)"><i class="icon-close"></i></a>
                                                <a href="javascript:void(0)"><i class="ti-heart text-danger"></i></a>    
                                            </span>
                                    </div>
                                </div>
                            </div>
                            <!-- Comment Row -->
                            <div class="d-flex no-block comment-row border-top">
                                <div class="p-2"><span class="round"><img src="{{asset('backend')}}/assets/images/users/3.jpg" alt="user" width="50"></span></div>
                                <div class="comment-text w-100">
                                    <h5 class="font-medium">Johnathan Doeting</h5>
                                    <p class="m-b-10 text-muted">Lorem Ipsum is simply dummy text of the printing and type setting industry. Lorem Ipsum has beenorem Ipsum is simply dummy text of the printing and type setting industry.</p>
                                    <div class="comment-footer">
                                        <span class="text-muted pull-right">April 14, 2016</span>
                                        <span class="badge badge-pill badge-danger">Rejected</span>
                                        <span class="action-icons">
                                                <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
                                                <a href="javascript:void(0)"><i class="ti-check"></i></a>
                                                <a href="javascript:void(0)"><i class="ti-heart"></i></a>    
                                            </span>
                                    </div>
                                </div>
                            </div>
                            <!-- Comment Row -->
                            <div class="d-flex no-block comment-row border-top">
                                <div class="p-2"><span class="round"><img src="{{asset('backend')}}/assets/images/users/4.jpg" alt="user" width="50"></span></div>
                                <div class="comment-text active w-100">
                                    <h5 class="font-medium">Genelia doe</h5>
                                    <p class="m-b-10 text-muted">Lorem Ipsum is simply dummy text of the printing and type setting industry. Lorem Ipsum has beenorem Ipsum is simply dummy text of the printing and type setting industry..</p>
                                    <div class="comment-footer">
                                        <span class="text-muted pull-right">April 14, 2016</span>
                                        <span class="badge badge-pill badge-success">Approved</span>
                                        <span class="action-icons active">
                                                <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
                                                <a href="javascript:void(0)"><i class="icon-close"></i></a>
                                                <a href="javascript:void(0)"><i class="ti-heart text-danger"></i></a>    
                                            </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">YOU HAVE 5 NEW MESSAGES</h5>
                            <div class="message-box" id="msg" style="height: 430px;position: relative;">
                                <div class="message-widget message-scroll">
                                    <!-- Message -->
                                    <a href="javascript:void(0)">
                                        <div class="user-img"> <img src="{{asset('backend')}}/assets/images/users/1.jpg" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Pavan kumar</h5> <span class="mail-desc">Lorem Ipsum is simply dummy text of the printing and type setting industry. Lorem Ipsum has been.</span> <span class="time">9:30 AM</span> </div>
                                    </a>
                                    <!-- Message -->
                                    <a href="javascript:void(0)">
                                        <div class="user-img"> <img src="{{asset('backend')}}/assets/images/users/2.jpg" alt="user" class="img-circle"> <span class="profile-status busy pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Sonu Nigam</h5> <span class="mail-desc">I've sung a song! See you at</span> <span class="time">9:10 AM</span> </div>
                                    </a>
                                    <!-- Message -->
                                    <a href="javascript:void(0)">
                                        <div class="user-img"> <span class="round">A</span> <span class="profile-status away pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Arijit Sinh</h5> <span class="mail-desc">Simply dummy text of the printing and typesetting industry.</span> <span class="time">9:08 AM</span> </div>
                                    </a>
                                    <!-- Message -->
                                    <a href="javascript:void(0)">
                                        <div class="user-img"> <img src="{{asset('backend')}}/assets/images/users/4.jpg" alt="user" class="img-circle"> <span class="profile-status offline pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
                                    </a>
                                    <!-- Message -->
                                    <a href="javascript:void(0)">
                                        <div class="user-img"> <img src="{{asset('backend')}}/assets/images/users/1.jpg" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Pavan kumar</h5> <span class="mail-desc">Welcome to the Elite Admin</span> <span class="time">9:30 AM</span> </div>
                                    </a>
                                    <!-- Message -->
                                    <a href="javascript:void(0)">
                                        <div class="user-img"> <img src="{{asset('backend')}}/assets/images/users/2.jpg" alt="user" class="img-circle"> <span class="profile-status busy pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Sonu Nigam</h5> <span class="mail-desc">I've sung a song! See you at</span> <span class="time">9:10 AM</span> </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Comment - chats -->
            <!-- ============================================================== -->
           
           
            @endif
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->


@endsection

@section('js')
    <!-- Chart JS -->
    <script src="{{asset('backend')}}/dist/js/dashboard1.js"></script>

@endsection


