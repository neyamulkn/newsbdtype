<?php echo '<?xml version="1.0" encoding="UTF-8" ?>'.PHP_EOL ?>
<rss version="2.0"
  xmlns:atom="http://www.w3.org/2005/Atom"
 
  >
<channel>
  <title>বিডি টাইপ</title>
  <link>{{ url('/') }}</link>
  <atom:link href="{{route('feed')}}" type="application/rss+xml" rel="self"/>
  <description>Online Latest Bangla News/Article - Sports, Crime, Entertainment, Business, Politics, Education, Opinion, Lifestyle, Photo, Video, Travel, National, World</description>
  <image>
    <url>{{ asset('frontend')}}/images/logo-black.png</url>
    <title>বিডি টাইপ</title>
    <link>>{{ url('/') }}</link>
  </image>

@foreach($get_feeds as $feed_news)
  <item>
    <title><![CDATA[{{$feed_news->news_title}}]]></title>
    <link>{{ route('news_details', $feed_news->news_slug)}}</link>
    <description><![CDATA[{!! str_limit($feed_news->news_dsc, 250 ) !!}]]></description>
  
    <pubDate>{{ date("r", strtotime(Carbon\Carbon::parse($feed_news->created_at)->format('d M Y H:i:s'))) }}</pubDate>
    <author><![CDATA[ {{ $feed_news->reporter->name }} ]]></author>
    <category>{{ $feed_news->categoryList->category_bd }}</category>
    <image>
      <url>{{ asset('upload/images/thumb_img_box/'. $feed_news->image->source_path)}}</url>
      <title>{{$feed_news->news_title}}</title>
      <link>{{ route('news_details', $feed_news->news_slug)}}</link>
    </image>
  </item>
@endforeach

</channel>
</rss>