@extends('member.default')

@section('title')FAQ @Stop

@section('faq-class')nav-active @Stop

@section('content')

<div class="row">
    <div class="col-md-12">
        <h2 class="pb-lg">Frequently Asked Questions (FAQs)</h2>
        <div class="toggle" data-plugin-toggle>
            @foreach($faqs as $faq)
            <section class="toggle">
                <label>{{$faq->question}}</label>
                <div class="toggle-content">
                    <p>{!!nl2br($faq->answer)!!}</p>
                </div>
            </section>
            @endforeach
        </div>
    </div>

@Stop