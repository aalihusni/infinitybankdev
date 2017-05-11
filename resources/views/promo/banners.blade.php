@extends('promo.default')

@section('title')How it work?  @Stop

@section('contactusclass')active @Stop

@section('extrameta')
<meta property="og:url"           content="{{ env('SITE_URL') }}/promo/{{$promopages->alias}}" />
<meta property="og:type"          content="website" />
<meta property="og:title"         content="{{$promobanners->title}}" />
<meta property="og:description"   content="{{$promobanners->description}}" />
<meta property="og:image"         content="{{asset('assets/banner/'.$promobanners->image)}}" />

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@bitregion">
<meta name="twitter:creator" content="@bitregion">
<meta name="twitter:title" content="{{$promobanners->title}}">
<meta name="twitter:description" content="{{$promobanners->description}}">
<meta name="twitter:image" content="{{asset('assets/banner/'.$promobanners->image)}}">
@Stop

@section('content')
<div role="main" class="main">
    <div class="container">

        @if($promobanners->type == 'image')
        <img width="100%" src="{{asset('assets/banner/'.$promobanners->image)}}" style="border:medium solid #333;"/>
        @else
        <video width="100%" autoplay controls>
            <source src="{{asset('download/'.$promobanners->video)}}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        @endif

        <div class="banner_description">
            <div class="row">
                <div class="col-lg-9">
                    <h4>{{$promobanners->title}}</h4>
                    <p>{{$promobanners->description}}</p>
                </div>
                <div class="col-lg-3"><a href="{{ env('SITE_URL') }}/redirect/promo/{{$promopages->alias}}/{{$logid}}" class="btn btn-primary btn-block btn-lg">Continue</a></div>
            </div>
        </div>
    </div>
</div>

@stop