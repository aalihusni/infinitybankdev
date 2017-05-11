@extends('member.default')

@section('title')Photo Gallery @Stop

@section('gallery-class')nav-active @Stop

@section('content')

    <style>
        img.square {
            height: 200px;
            width: 200px;
            object-fit: cover;
        }
    </style>

<div class="row">
    <div class="col-md-12">
        <div class="row mg-files" data-sort-destination data-sort-id="media-gallery">
            @foreach($objectData as $album)

                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="text-center">
                        <div class="thumb-preview text-center">
                            <a class="thumb-image text-center" href="{{URL::route('gallery-view', ['id' => $album->id])}}">
                                <img src="../gallery/{{$album->images}}" class="square img-responsive img-thumbnail text-center" alt="Project">
                            </a>
                        </div>
                        <h5 class="mg-title text-weight-semibold text-center">{{$album->title}}<br><small>{{$album->count}} pictures</small></h5>
                    </div>
                </div>

                @endforeach

        </div>
    </div>
</div>
@Stop