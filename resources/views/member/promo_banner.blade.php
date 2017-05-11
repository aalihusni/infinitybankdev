@extends('member.default')

@section('title')Banners & Videos @Stop

@section('promobanners-class')nav-active @Stop
@section('promo-class')nav-expanded nav-active @Stop
@section('menu_setting') @Stop

@section('content')

<div class="col-md-12">
    <div class="row">

        @foreach($promobanners as $promobanner)

        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-body">

                    <a class="mb-xs mt-xs mr-xs modal-basic" href="#banner{{$promobanner->alias}}">
                        <img width="100%" src="{{asset('assets/banner/'.$promobanner->image)}}"/>
                    </a>
                    <table width="100%">
                        <tr>
                            <td><strong>Click-through:</strong> {{$promobanner->clicktru}}%</td>
                            <td align="right"><strong>View:</strong> {{$promobanner->totalView}}</td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>

        <div id="banner{{$promobanner->alias}}" class="modal-block mfp-hide">
            <section class="panel">
                <header class="panel-heading">
                    <span class="modal-dismiss pull-right fa fa-close btn"></span>
                    <h2 class="panel-title">{{$promobanner->title}}</h2>
                </header>
                <div class="panel-body">
                    @if($promobanner->type == 'image')
                    <img width="100%" src="{{asset('assets/banner/'.$promobanner->image)}}"/>
                    @else
                    <video width="100%" controls>
                        <source src="{{asset('download/'.$promobanner->video)}}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    @endif
                    <br><br>
                    <p>{{$promobanner->description}}</p>
                    <hr>
                    <div>Promotional Link</div>
                    {!! Form::text('firstname', 'http://bitregion.com/promo/'.$promobanner->alias.'/'.Auth::user()->alias, array('class'=>'form-control','onClick'=>'this.select();')) !!}
                    <hr>
                    <p><table width="100%">
                        <tr>
                            <td><strong>Landing Page:</strong> {{$promobanner->title}}</td>
                            <td align="right">
                                <a href="whatsapp://send" class="visible-xs pull-right" data-text="{{$promobanner->title}}" data-href="https://bitregion.com/promo/{{$promobanner->alias}}/{{Auth::user()->alias}}"><img width="20" src="{{asset('assets/social/ws.png')}}"/>&nbsp;&nbsp;</a>
                                <a class="pull-right" href="javascript:twShare('https://bitregion.com/promo/{{$promobanner->alias}}/{{Auth::user()->alias}}', 520, 350)"><img width="20" src="{{asset('assets/social/tw.png')}}"/>&nbsp;&nbsp;</a>
                                <a class="pull-right" href="javascript:fbShare('https://bitregion.com/promo/{{$promobanner->alias}}/{{Auth::user()->alias}}', '{{$promobanner->title}}', '{{$promobanner->description}}', 'https://bitregion.com/{{$promobanner->alias}}/{{Auth::user()->alias}}', 520, 350)"><img  width="20" src="{{asset('assets/social/fb.png')}}"/>&nbsp;&nbsp;</a>
                            </td>
                        </tr>
                    </table></p>
                </div>
            </section>
        </div>

        @endforeach

    </div>
</div>

<script type="text/javascript">
    $('.modal-basic').magnificPopup({
        type: 'inline',
        preloader: false,
        modal: true
    });

    $(document).on('click', '.modal-dismiss', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
    });
</script>

<script>
    function fbShare(url, title, descr, image, winWidth, winHeight) {
        var winTop = (screen.height / 2) - (winHeight / 2);
        var winLeft = (screen.width / 2) - (winWidth / 2);
        window.open('http://www.facebook.com/sharer.php?s=100&p[title]=' + title + '&p[summary]=' + descr + '&p[url]=' + url + '&p[images][0]=' + image, 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
    }
    function twShare(url, winWidth, winHeight) {
        var winTop = (screen.height / 2) - (winHeight / 2);
        var winLeft = (screen.width / 2) - (winWidth / 2);
        window.open('https://twitter.com/home?status=' + url , 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
    }
</script>
@Stop