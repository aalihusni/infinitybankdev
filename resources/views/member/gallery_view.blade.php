@extends('member.default')

@section('title')Photo Gallery @Stop

@section('gallery-class')nav-active @Stop

@section('content')
    <style>
        img.square {
            height: 140px;
            width: 140px;
            object-fit: cover;
        }
    </style>
<div class="row">
    <div class="col-md-12">
        <div class="row mg-files" data-sort-destination data-sort-id="media-gallery">

                <section class="panel">
                    <header class="panel-heading">
                        <a href="{{URL::route('gallery')}}" class="pull-right">< Back to Albums</a>
                        <h2 class="panel-title">{{$album->title}}</h2>
                        <p class="panel-subtitle">{{$album->description}}</p>
                    </header>
                    <div class="panel-body">
                        <div class="popup-gallery">

                            @foreach($images as $image)

                                <a class="pull-left mb-xs mr-xs" href="../gallery/{{$image->image_file}}">
                                    <div class="img-responsive">
                                        <img class="square img-thumbnail" src="../gallery/{{$image->image_file}}" width="200">
                                    </div>
                                </a>


                            @endforeach
                        </div>
                    </div>
                </section>

        </div>
    </div>
</div>

<script type="text/javascript">
    $('.popup-gallery').magnificPopup({
        delegate: 'a',
        type: 'image',
        tLoading: 'Loading image #%curr%...',
        mainClass: 'mfp-img-mobile',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0,1] // Will preload 0 - before current, and 1 after the current image
        },
        image: {
            tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
        }
    });
</script>
@Stop