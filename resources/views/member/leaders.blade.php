@extends('member.default')

@section('title')Country Leaders @Stop

@section('leader-class')nav-active @Stop

@section('content')

<div class="row">
    <div class="col-md-12">
        <h2 class="pb-lg">Country Leaders</h2>
        <div class="toggle" data-plugin-toggle>
            <?php
            $country = '';
            ?>
            @foreach($leaders as $leader)
                @if($country != $leader->country_code)
                @if($country != '')
                    </div>
                    </section>
                @endif
                <section class="toggle">
                    <label class="country_code" id="{{ $leader->country_code }}">{{ $leader->country_code }}</label>
                    <div class="toggle-content">
                @endif
                    <div class="well col-sm-6">
                        <img style="margin-right:10px;" src="{{S3Files::url('profiles')}}/{{$leader->profile_pic}}" align="left" width="70" class="img-rounded"/>
                        <strong>{{$leader->firstname}} {{$leader->lastname}}</strong><br>
                        {{$leader->city}}, {{$leader->state}}<br>
                        @if($leader->mobile)
                            <span class="fa fa-2x fa-mobile text-primary" data-toggle="tooltip" data-placement="top" title="Mobile: {{$leader->mobile}}"></span>&nbsp;
                        @endif
                        @if($leader->sos_qq)
                            <span class="fa fa-2x fa-qq text-primary" data-toggle="tooltip" data-placement="top" title="qq: {{$leader->sos_qq}}"></span>&nbsp;
                        @endif
                        @if($leader->sos_wechat)
                            <span class="fa fa-2x fa-wechat text-primary" data-toggle="tooltip" data-placement="top" title="WeChat: {{$leader->sos_wechat}}"></span>&nbsp;
                        @endif
                        @if($leader->sos_whatsapp)
                            <span class="fa fa-2x fa-whatsapp text-primary" data-toggle="tooltip" data-placement="top" title="Whatsapp: {{$leader->sos_whatsapp}}"></span>&nbsp;
                        @endif
                        @if($leader->sos_line)
                            <span class="fa fa-2x fa-minus-square text-primary" data-toggle="tooltip" data-placement="top" title="Line: {{$leader->sos_line}}"></span>&nbsp;
                        @endif
                        @if($leader->sos_viber)
                            <span class="fa fa-2x fa-vimeo-square text-primary" data-toggle="tooltip" data-placement="top" title="Viber: {{$leader->sos_viber}}"></span>&nbsp;
                        @endif
                        @if($leader->sos_skype)
                            <span class="fa fa-2x fa-skype text-primary" data-toggle="tooltip" data-placement="top" title="Skype: {{$leader->sos_skype}}"></span>&nbsp;
                        @endif
                        @if($leader->sos_bbm)
                            <span class="fa fa-2x fa-weixin text-primary" data-toggle="tooltip" data-placement="top" title="BBM: {{$leader->sos_bbm}}"></span>&nbsp;
                        @endif
                    </div>
            <?php $country = $leader->country_code;?>
            @endforeach
                    </div>
                    </section>
        </div>
    </div>

<script>
    $(document).ready(function() {
        country_name()
    });

    function country_name()
    {
        $('.country_code').each(function() {
            var country_code = $(this).attr('id');
            var loadUrl = 'https://restcountries.eu/rest/v1/alpha?codes=' + country_code;
            $.ajax({dataType: "json", url: loadUrl, success: function(result) {
                $('#'+country_code).html('<i class="fa fa-plus"></i><i class="fa fa-minus"></i>'+result[0]['name']);
            }});
        });
    }
</script>
@Stop