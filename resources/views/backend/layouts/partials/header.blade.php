<header class="topbar"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <!-- ============================================================== -->
        <!-- Logo -->
        <!-- ============================================================== -->
        <div class="navbar-header">
            <a class="navbar-brand" href="{{route('home')}}">
                <!-- Logo icon --><b>
                    <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                    <!-- Dark Logo icon -->
                    <img src="{{asset('backend')}}/assets/images/logo-icon.png" width="65%" alt="homepage" class="dark-logo" />
                    <!-- Light Logo icon -->
                    <img src="{{ asset('frontend')}}/assets/images/logo-black.png" width="65%" alt="homepage" class="light-logo" />
                </b>
                <!--End Logo icon -->
                <!-- Logo text --><span>
                 <!-- dark Logo text -->
                 <img src="{{ asset('frontend')}}/images/logo-black.png" width="65%" alt="homepage" class="dark-logo" />
                 <!-- Light Logo text -->
                 <img src="{{ asset('backend')}}/images/logo-black.png" width="65%" class="light-logo" alt="homepage" /></span> </a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav mr-auto">
                <!-- This is  -->
                <li class="nav-item"> <a class="nav-link nav-toggler d-block d-md-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                <!-- ============================================================== -->
                <!-- Search -->
                <!-- ============================================================== -->
                <li class="nav-item">
                    <form class="app-search d-none d-md-block d-lg-block">
                        <input type="text" class="form-control" placeholder="Search & enter">
                    </form>
                </li>
            </ul>
            <!-- ============================================================== -->
            <!-- User profile and search -->
            <!-- ============================================================== -->
            <ul class="navbar-nav my-lg-0">
                <!-- ============================================================== -->
         
                <!-- Messages -->
                <!-- ============================================================== -->
                <?php $notifications = App\Models\Notification::where('toUser', Auth::id())->orderBy('id', 'desc')->get(); ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="icon-bell"></i>
                        @if(count($notifications->where('read', 0))>0)
                        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                        @endif
                    </a>
                    @if(count($notifications)>0)
                    <div class="dropdown-menu mailbox dropdown-menu-right animated bounceInDown" aria-labelledby="2">
                        <ul>
                            
                            <li>
                                <div class="message-center">
                                     @foreach($notifications->take(7) as $notification)

                                        @if($notification->type == env('NEWS'))
                                           
                                            <a onclick="readNotify('{{$notification->id}}')" @if($notification->news->status == 1) href="{{route('news.list')}}" @elseif($notification->news->status == 2) href="{{route('news.draft')}}" @else  href="{{route('news.pending')}}" @endif>
                                                <div class="user-img"> <img src="{{asset('upload/images/users/thumb_image/'.$notification->user->image)}}" alt="user" class="img-circle"></div>
                                                <div class="mail-contnet">
                                                    <h5>{{$notification->user->username}}</h5> <span class="mail-desc"><strong>{{$notification->notify}} </strong> - {{str_limit($notification->news->news_title, 20)}}</span> <span class="time">{{$notification->created_at->diffForHumans()}}</span>
                                                </div>
                                            </a>
                                        @endif

                                        @if($notification->type == env('COMMENT'))
                                           
                                            <a onclick="readNotify('{{$notification->id}}')"  href="{{route('comments',$notification->comment->news->news_slug)}}#singleComment{{$notification->item_id}}">
                                                <div class="user-img"> <img src="{{asset('upload/images/users/thumb_image/'.$notification->user->image)}}" alt="user" class="img-circle"></div>
                                                <div class="mail-contnet">
                                                    <h5>{{$notification->user->username}}</h5> <span class="mail-desc"><strong>{{$notification->notify}} </strong> - {{str_limit($notification->comment->comments, 20)}}</span> <span class="time">{{$notification->created_at->diffForHumans()}}</span> </div>
                                            </a>
                                        @endif

                                        @if($notification->type == env('REPORTER_NOTIFY'))
                                           
                                                @if(Auth::user()->role_id != env('ADMIN'))
                                                <a onclick="readNotify('{{$notification->id}}')" href="{{route('user_profile', $notification->user->username)}}">
                                                @endif
                                                @if(Auth::user()->role_id == env('ADMIN'))
                                                <a onclick="readNotify('{{$notification->id}}')" href="{{route('reporterRequest.list')}}">
                                                @endif
                                                <div class="user-img"> <img src="{{asset('upload/images/users/thumb_image/'.$notification->user->image)}}" alt="user" class="img-circle"></div>
                                                <div class="mail-contnet">
                                                    <h5>{{$notification->user->username}}</h5> <span class="mail-desc"><strong>{{$notification->notify}} </strong> </span> <span class="time">{{$notification->created_at->diffForHumans()}}</span>
                                                </div>
                                            </a>
                                        @endif

                                    @endforeach
                                </div>
                            </li>
                            @if(count($notifications)>6)
                            <li>
                                <a class="nav-link text-center link" href="{{route('notifications')}}"> <strong>See all </strong> <i class="fa fa-angle-right"></i> </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                    @endif
                </li>
                <!-- ============================================================== --> 
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="icon-note"></i>
                        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                    </a>
                    <div class="dropdown-menu mailbox dropdown-menu-right animated bounceInDown" aria-labelledby="2">
                        <ul>
                            
                            <li>
                                <div class="message-center">
                                    <!-- Message -->
                                    <a href="javascript:void(0)">
                                        <div class="user-img"> <img src="{{asset('backend')}}/assets/images/users/1.jpg" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:30 AM</span> </div>
                                    </a>
                                    <!-- Message -->
                                    <a href="javascript:void(0)">
                                        <div class="user-img"> <img src="{{asset('backend')}}/assets/images/users/2.jpg" alt="user" class="img-circle"> <span class="profile-status busy pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Sonu Nigam</h5> <span class="mail-desc">I've sung a song! See you at</span> <span class="time">9:10 AM</span> </div>
                                    </a>
                                    <!-- Message -->
                                    <a href="javascript:void(0)">
                                        <div class="user-img"> <img src="{{asset('backend')}}/assets/images/users/3.jpg" alt="user" class="img-circle"> <span class="profile-status away pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Arijit Sinh</h5> <span class="mail-desc">I am a singer!</span> <span class="time">9:08 AM</span> </div>
                                    </a>
                                    <!-- Message -->
                                    <a href="javascript:void(0)">
                                        <div class="user-img"> <img src="{{asset('backend')}}/assets/images/users/4.jpg" alt="user" class="img-circle"> <span class="profile-status offline pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <a class="nav-link text-center link" href="javascript:void(0);"> <strong>See all e-Mails</strong> <i class="fa fa-angle-right"></i> </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- ============================================================== -->
            
                <!-- User Profile -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown u-pro">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('upload/images/users/thumb_image/'. Auth::user()->image)}}" alt="user" class=""> <span class="hidden-md-down"> &nbsp;<i class="fa fa-angle-down"></i></span> </a>
                    <div class="dropdown-menu dropdown-menu-right animated flipInY">
                        <!-- text-->
                        <a href="javascript:void(0)" class="dropdown-item"><i class="ti-user"></i> My Profile</a>
                        <!-- text-->
                        <a href="javascript:void(0)" class="dropdown-item"><i class="ti-wallet"></i> My Balance</a>
                        <!-- text-->
                        <a href="javascript:void(0)" class="dropdown-item"><i class="ti-email"></i> Inbox</a>
                        <!-- text-->
                        <div class="dropdown-divider"></div>
                        <!-- text-->
                        <a href="javascript:void(0)" class="dropdown-item"><i class="ti-settings"></i> Setting</a>
                        <!-- text-->
                        <div class="dropdown-divider"></div>
                        <!-- text-->
                        <a  href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>
                        <!-- text-->
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- End User Profile -->
                <!-- ============================================================== -->
                <li class="nav-item right-side-toggle"> <a class="nav-link  waves-effect waves-light" href="javascript:void(0)"><i class="ti-settings"></i></a></li>
            </ul>
        </div>
    </nav>
</header>
