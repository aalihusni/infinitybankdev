@extends('member.default')

@section('title'){{ trans('manageaccount.manage_network_account') }} @Stop

@section('manageaccount-class')nav-active @Stop
@section('menu_setting') @Stop

@section('content')

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">

    <div class="col-md-8">

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-lg-8">
                    <img class="img-rounded" src="{{asset('profiles/no_img.jpg')}}" width="40" align="left" style="margin-right:15px; margin-left:-10px;"/>
                    <h2 class="panel-title">{{ trans('manageaccount.manage_account') }} {{ $user_details['alias'] }}</h2>
                    <p class="panel-subtitle">{{ trans('manageaccount.member_since') }} {{ $user_details['created_at']->format('d M Y') }}</p>
                </div>
                <div class="col-lg-4">
                    <a class="btn btn-primary btn-block modal-popup" href="{{URL::route('network')}}">{{ trans('manageaccount.back_to_network_list') }}</a>
                </div>
            </div>
        </div>

        {{--*/ $tab_assistant = "" /*--}}
        {{--*/ $tab_bank = "" /*--}}
        {{--*/ $tab_pairing = "" /*--}}
        @if ($tab == "assistant")
            {{--*/ $tab_assistant = 'class="active"' /*--}}
        @endif
        @if ($user_details['user_type'] == 2)
        @if ($tab == "bank")
            {{--*/ $tab_bank = 'class="active"' /*--}}
        @endif
        @if ($tab == "pairing")
            {{--*/ $tab_pairing = 'class="active"' /*--}}
        @endif
        @endif

        <div class="tabs">
            <ul class="nav nav-tabs">
                <li {!! $tab_assistant !!}>
                    <a id="assistant_ajax" href="#popular" data-toggle="tab">{{ trans('manageaccount.agb') }}</a>
                </li>
                @if ($user_details['user_type'] == 2)
                <li {!! $tab_bank !!}>
                    <a id="ph_ajax" href="#recent" data-toggle="tab">{{ trans('manageaccount.ph') }}</a>
                </li>
                <li {!! $tab_pairing !!}>
                    <a id="pairing_ajax" href="#recent" data-toggle="tab">{{ trans('manageaccount.pairing') }}</a>
                </li>
                @endif
            </ul>
            <div class="tab-content">
                <div id="content" class="tab-pane active">
                    <p>Loading</p>
                </div>
            </div>
        </div>



    </div>




    <div class="col-md-4">
        <div class="well">
            <p><strong>{{ trans('manageaccount.instruction') }}</strong></p>
            <p>{{ trans('manageaccount.i_one') }}</p>
            <p>{{ trans('manageaccount.i_two') }}</p>
        </div>
    </div>



</div>

<script type="text/javascript">

    $( document ).ready(function() {
        @if ($tab == "bank")
            load_ph();
        @elseif ($tab == "pairing")
            load_pairing();
        @else
            load_assistant();
        @endif
    });

    $('#assistant_ajax').click(function(){
        load_assistant();
    })

    $('#ph_ajax').click(function(){
        load_ph();
    })

    $('#pairing_ajax').click(function(){
        load_pairing();
    })

    function load_assistant()
    {
        var loadUrl = "{{URL::to('/')."/members/ajax-assistant/".$crypt_id}}";
        $('#content').html('loading')
                .load(loadUrl);
    }

    function load_ph()
    {
        var loadUrl = "{{URL::to('/')."/members/ajax-provide-help/".$crypt_id}}";
        $('#content').html('loading')
                .load(loadUrl);
    }

    function load_pairing()
    {
        var loadUrl = "{{URL::to('/')."/members/ajax-pairing/".$crypt_id}}";
        $('#content').html('loading')
                .load(loadUrl);
    }

</script>
@Stop