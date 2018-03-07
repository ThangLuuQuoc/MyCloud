@extends('layouts.app', ['title' => 'Convert Video to GIF'])

@section('styles')
    <link rel="stylesheet" href="//vjs.zencdn.net/5.19.1/video-js.min.css">
    {!! Html::style('assets/admin/assets/plugins/sweet-alert/sweetalert.css') !!}

    <style>
        .time {
            margin-top: 25px;
        }

        .transparent {
            background-color: rgba(255, 255, 255, 0.8) !important;
        }
    </style>
@endsection

@section('content')
<!-- Main container -->
<main>
    <!-- Video to Gif section -->
    <section class="no-border-bottom section-sm">

        <header class="section-header">
            <span>Create a Gif</span>
            <h2>From over 1000 video hosts</h2>
            <p>It is as easy as 1, 2, 3</p>
        </header>

        <div class="col-md-8 col-md-offset-2">
            <div class="form-group">
                {!! Form::text('url', '', ['id' => 'url', 'placeholder' => 'For example: https://www.youtube.com/watch?v=3cxixDgHUYw', 'class' => 'form-control']) !!}
            </div>
        </div>

        <div class="col-md-2 col-md-offset-5 col-sm-2 col-sm-offset-5">
            <div class="form-group text-center">
                <span class="btn btn-sm btn-primary start">Start</span>
            </div>
        </div>


        <div class="video-player col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 hide">
            <p class="lead">Is this the video?</p>
            <video id="media" class="video-js vjs-big-play-centered">
                <p class="vjs-no-js">
                    {{ trans('media_index.enable_js_video') }}
                    <a href="http://browsehappy.com/" target="_blank">{{ trans('media_index.support_html5_video') }}</a>
                </p>
            </video>

            <div class="row time">
                <div class="col-md-4 col-sm-4">
                    <label for="caption">Add Text:</label>
                    <input name="caption" id="caption" type="text" placeholder="I am a caption." />
                </div>

                <div class="col-md-4 col-sm-4">
                    <p class="small">Navigate the video to where you want to start your GIF.</p>
                </div>


                <div class="col-md-4 col-sm-4">
                    <div class="pull-right">
                        <label for="duration">Duration:</label>
                        <input name="duration" id="duration" type="number" placeholder="1-15 seconds" />
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-md-offset-5" style="margin-top: 30px;">
                <div class="form-group">
                    <span class="btn btn-sm btn-primary create">Create GIF</span>
                </div>
            </div>
        </div>
    </section>
    <!-- END Video to Gif section -->
</main>
<!-- END Main container -->
@endsection

@section('scripts')
    <script src="//vjs.zencdn.net/5.19.1/video.min.js"></script>
    <script src="{{ url('assets/js/videojs/videojs.hotkeys.min.js') }}"></script>
    <script src="{{ url('assets/js/videojs/videojs-brand.js') }}"></script>

    {!! Html::script('assets/admin/assets/plugins/sweet-alert/sweetalert.min.js') !!}

    <script>
    var stream_url;
    var player = '';

    $('.start').on('click', function (event) {
        getDirectURL();
    });

    $('.create').on('click', function (event) {
        var duration = $("#duration").val();

        if (duration > 0 && duration <= 15) {
            startConverting(duration, player.currentTime());
        } else {
            swal("Error!", "There was an error, because you entered wrong start or duration values.", "error");
        }
    });


    function getDirectURL() {
        stream_url = $("#url").val();

        var data = {
            stream_url: stream_url,
            _token: "{{ csrf_token() }}",
        };

        $.ajax({
            url : "{{ route('vidgif.stream_url') }}",
            type : 'POST',
            data : data,
            dataType : 'json',
            beforeSend: function () {
                swal({
                    title: "Sweet!",
                    text: "We are retrieving the stream URL.",
                    imageUrl: "{{ url('assets/images/loading.gif') }}",
                    showConfirmButton: false
                });
            },
            success : function (result) {
                direct_url = result['direct_url'];
                swal({
                    title: "Yay!",
                    text: "We got it.",
                    type: "success",
                    timer: 1250,
                    showConfirmButton: false
                });
                initializePlayer(result['direct_url']);
            },
            error : function () {
                swal("Error!", "There was an error getting the stream URL or we might not be able to process videos from this site.", "error");
            }
        });
    }

    function startConverting(duration, start) {
        var data = {
            start: start,
            duration: duration,
            caption: $("#caption").val(),
            stream_url: stream_url,
            _token: "{{ csrf_token() }}",
        };

        $.ajax({
            url : "{{ route('vidgif.convert') }}",
            type : 'POST',
            data : data,
            dataType : 'json',
            beforeSend: function () {
                swal({
                    title: "Doing it now!",
                    text: "We are creating your GIF right now. Hang tight.",
                    imageUrl: "{{ url('assets/images/loading.gif') }}",
                    showConfirmButton: false
                });
            },
            success : function (result) {
                swal({
                    title: "Yay!",
                    text: "We got it.",
                    type: "success",
                    timer: 1250,
                    showConfirmButton: false
                }, function() {
                    window.location.href = "{{ url('/m').'/' }}" + result['key'];
                });
            },
            error : function () {
                swal("Error!", "There was an error getting the stream URL or we might not be able to process videos from this site.", "error");
            }
        });
    }

    function initializePlayer(src) {
        $(".video-player").removeClass('hide');

        player = videojs('media', {
            fluid: true,
            controls: true,
            loop: false,
            autoplay: true,
            playbackRates: [0.5, 0.75, 1, 1.25, 1.5, 1.75, 2]
        });

        player.src({
            type: "video/mp4",
            src: src,
        });

        player.brand({
            image: "{{ url('assets/images/brand.png') }}",
            title: "{{ config('website_title') }}",
            destination: "{{ url('/') }}",
            destinationTarget: "_top"
        });

        player.hotkeys({
            seekStep: 10,
            enableNumbers: false,
            volumeStep: .1,
            enableVolumeScroll: false
        });
    }
</script>
@endsection
