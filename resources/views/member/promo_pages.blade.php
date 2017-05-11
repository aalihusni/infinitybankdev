@extends('member.default')

@section('title')Landing Pages @Stop

@section('promopages-class')nav-active @Stop
@section('promo-class')nav-expanded nav-active @Stop
@section('menu_setting') @Stop

@section('content')
<style>
    .flags {
        border:medium solid #FFFFFF;
        padding:3px;
        cursor:pointer;
    }
    .langsel {
        border:medium solid #e2a129;
        padding:3px;
    }
</style>

<div class="col-md-12">
    <div class="row">
        @foreach($promopages as $promopage)
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-4">
                        <img width="100%" src="{{asset('web_content/img/'.$promopage->image)}}"/>
                    </div>
                    <div id="page_{{$promopage->id}}" class="col-lg-8">
                        <h4><a href="https://bitregion.com/{{$promopage->alias}}/{{Auth::user()->alias}}" target="_blank">{{$promopage->title}}</a></h4>
                        <p>{{$promopage->description}}</p>
                        <p></p>
                        <p>Language:
                            @foreach($promopage->lang as $lang)
                            <img url-data="https://bitregion.com/{{$promopage->alias}}/{{Auth::user()->alias}}?lang={{$lang}}" class="flags" src="{{ asset('assets/plugin/polygot/images/flags/'.$lang.'.png') }}"/>
                            @endforeach
                        </p>
                        <p></p><table width="100%">
                            <tr>
                                <td><strong>View: {{$promopage->totalView}}</strong></td>
                                <td class="hidden-xs">Opt-in: {{$promopage->OptinCount}}</td>
                                <td class="hidden-xs">Closed: {{$promopage->CloseCount}}</td>
                                <td align="right">
                                    <a href="whatsapp://send" class="visible-xs pull-right" data-text="{{$promopage->title}}" data-href="https://bitregion.com/{{$promopage->alias}}/{{Auth::user()->alias}}"><img width="20" src="{{asset('assets/social/ws.png')}}"/>&nbsp;&nbsp;</a>
                                    <a class="pull-right" href="javascript:twShare('https://bitregion.com/{{$promopage->alias}}/{{Auth::user()->alias}}', 520, 350)"><img width="20" src="{{asset('assets/social/tw.png')}}"/>&nbsp;&nbsp;</a>
                                    <a class="pull-right" href="javascript:fbShare('https://bitregion.com/{{$promopage->alias}}/{{Auth::user()->alias}}', '{{$promopage->title}}', '{{$promopage->description}}', 'https://bitregion.com/{{$promopage->alias}}/{{Auth::user()->alias}}', 520, 350)"><img  width="20" src="{{asset('assets/social/fb.png')}}"/>&nbsp;&nbsp;</a>
                                </td>
                            </tr>
                        </table></p>
                        {!! Form::text('firstname', 'https://bitregion.com/'.$promopage->alias.'/'.Auth::user()->alias, array('class'=>'form-control theurl','onClick'=>'this.select();')) !!}
                    </div>
                </div>

            </div>
        </div>

            <script type="text/javascript">
                $("#page_{{$promopage->id}} .flags").click(function(){
                    $('#page_{{$promopage->id}} .flags').removeClass('langsel');
                    $(this).addClass('langsel');
                    var theurl = $(this).attr('url-data');
                    $("#page_{{$promopage->id}} .theurl").val(theurl);
                })
            </script>
        @endforeach


    </div>
</div>
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