@extends('member.default')

@section('title')News & Annoucement @Stop

@section('news-class')nav-active @Stop

@section('content')

<div class="row">
    <div class="col-md-12">
        <h2 class="pb-lg">News & Annoucements</h2>
        <div class="toggle" data-plugin-toggle>
            @foreach($news as $new)
            <section class="toggle">
                <label>{{$new->title}}</label>
                <div class="toggle-content">
                    <p>{!!nl2br($new->news)!!}</p>
                    <strong>{{date('F d, Y h:mA', strtotime($new->created_at))}}</strong>
                </div>
            </section>
            @endforeach
        </div>
    </div>

@Stop