@extends('frontend.layouts.master')
@section('titleMeta')
    <title>{{ ($subcategory) ? $subcategory->subcategory_bd. " | " : ''}} {{$category->category_bd}} | বিডি টাইপ </title>
    <meta name="description" content="">
    <meta name="image" content="">
    <meta name="rating" content="5">
    <!-- Schema.org for Google -->
    <meta itemprop="name" content="Bdtype online news">
    <meta itemprop="description" content="">
    <meta itemprop="image" content="">
@endsection

@section('content')
        <?PHP
function banglaDate($date){
    $engDATE = array(1,2,3,4,5,6,7,8,9,0, 'January', 'February', 'March','April', 'May', 'June', 'July', 'August','September', 'October', 'November', 'December', 'Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday');
        
    $bangDATE = array('১','২','৩','৪','৫','৬','৭','৮','৯','০','জানুয়ারী','ফেব্রুয়ারী','মার্চ','এপ্রিল','মে','জুন','জুলাই','আগস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর','শনিবার','রবিবার','সোমবার','মঙ্গলবার',' বুধবার','বৃহস্পতিবার','শুক্রবার' );
    $formatBng = Carbon\Carbon::parse($date)->format('j F, Y');
    $convertedDATE = str_replace($engDATE, $bangDATE, $formatBng);
    return $convertedDATE;
    }
?>
    <!-- block-wrapper-section
        ================================================== -->
    <section class="ticker-news category">

        <div class="container">
            <div class="category-title">
                <div class="row">
                <div class="col-sm-8">
                    <div class="category-title">
                        <span class="breaking-news" id="head-title">{{ ($subcategory) ? $subcategory->subcategory_bd : $category->category_bd }}</span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <img src="{{ asset('frontend')}}/upload/addsense/add.jpg" height="45">
                </div>
            </div>
            </div>
        </div>
    </section>

    <section class="block-wrapper">
        <div class="container section-body">
            <div class="row">
                <div class="col-sm-9">
                    @if($subcategory)
                    <ul class="category-news">
                        <li><i class="fa fa-home"></i><a href="{{ route('category', [$category->cat_slug_en]) }}"> {{$category->category_bd}} </a> / <a href="{{ route('category', [$category->cat_slug_en, $subcategory->subcat_slug_en]) }}">{{$subcategory->subcategory_bd}} </a></li>
                    </ul>
                    @endif
                    @if(count($categories) > 0)
                        <div class="grid-box">
                            <div class="row">
                                
                                <?php $i = 1;?>
                                    @foreach($categories as $category)
                                        @if(Request::get('page') <= 1)
                                            @if($i==1)
                                                <div class="col-md-6 col-sm-6" >
                                                    <div class="news-post standard-post2">
                                                        <div class="post-gallery">
                                                            <img src="{{ asset('upload/images/'. $category->image->source_path)}}" alt="">
                                                           
                                                        </div>
                                                        <div class="post-title box_title">
                                                            <h2><a href="{{route('news_details', $category->news_slug)}}">{{str_limit($category->news_title, 70)}} </a></h2>
                                                            <ul class="post-tags">
                                                               
                                                            <li> @if($category->subcategoryList)
                                                                <i class="fa fa-tags"></i>{{$category->subcategoryList->subcategory_bd}}@endif
                                                            </li>
                                                            
                                                                <li><i class="fa fa-clock-o"></i>{{banglaDate($category->publish_date)}}</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-md-3 col-sm-3">
                                                    <div class="news-post standard-post2">
                                                        <div class="post-gallery">
                                                            <img src="{{ asset('upload/images/thumb_img/'. $category->image->source_path)}}" alt="">
                                                            
                                                        </div>
                                                        <div class="post-title">
                                                            <h2><a href="{{route('news_details', $category->news_slug)}}">{{str_limit($category->news_title, 40)}} </a></h2>
                                                            <ul class="post-tags">
                                                               
                                                            <li> @if($category->subcategoryList)
                                                                <i class="fa fa-tags"></i>{{$category->subcategoryList->subcategory_bd}}@endif
                                                            </li>
                                                            
                                                                <li><i class="fa fa-clock-o"></i>{{banglaDate($category->publish_date)}}</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            <div class="col-md-3 col-sm-3">
                                                <div class="news-post standard-post2">
                                                    <div class="post-gallery">
                                                        <img src="{{ asset('upload/images/thumb_img/'. $category->image->source_path)}}" alt="">
                                                        
                                                    </div>
                                                    <div class="post-title">
                                                        <h2><a href="{{route('news_details', $category->news_slug)}}">{{str_limit($category->news_title, 40)}} </a></h2>
                                                        <ul class="post-tags">
                                                            <li> @if($category->subcategoryList)
                                                                <i class="fa fa-tags"></i>{{$category->subcategoryList->subcategory_bd}}@endif</li>
                                                            <li><i class="fa fa-clock-o"></i>{{banglaDate($category->publish_date)}}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                        @endif
                                     <?php $i++;?>
                                    @endforeach

                            </div>
                        </div>
                        <!-- pagination box -->
                        <div class="pagination-box">
                            {{$categories->links()}}
                        </div>
                        <!-- End Pagination box -->
                    @else
                        <h1>{{ __('lang.news_not_fount') }}</h1>
                    @endif
                </div>

                <div class="col-sm-3 div_border">

                    <!-- sidebar -->
                    @include('frontend.layouts.sitebar')
                    <!-- End sidebar -->

                </div>

            </div>
        </div>
    </section>
    <!-- End block-wrapper-section -->

@endsection
