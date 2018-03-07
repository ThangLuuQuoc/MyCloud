@php
if (str_contains($media->cloned, 'openload')) {
    $download_url = '';
} else {
    $download_url = $media->downloadUrl();
}
@endphp
@extends('layouts.app', ['title' => $media->title])

@section('styles')
    @include('components.media_styles', ['media' => $media])

    <style>
        @if ($media->isFont())
            @font-face {
                font-family: 'UploadedFont';
                src: url('{{ $media->downloadUrl() }}') format('{{ ($media->isFont() == 'ttf') ? 'truetype' : $media->isFont() }}');
            }
        .uploaded-font span {
            font-family: 'UploadedFont', Fallback, sans-serif;
            font-size: 36px;
            line-height: 75px;
        }
        @endif
        #block {
            margin-top: 0px;
        }
        section {
            padding: 50px 32px;
        }
        .image-gallery img {
            display: block;
            margin: 0 auto;
        }
        .photo-list img {
            width: 100%;
            height: 100px;
            cursor: pointer;
            object-fit: contain;
        }
        .lg-outer .lg-thumb-item img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
    </style>
@endsection

@section('content')

    <!-- Main container -->
    <main>

        <section class="no-border-bottom">
            <div class="container">

                @include('components.flash_notification')

                @if (! $password)

                    <div class="row">
                        <div class="col-xs-12 col-md-8">

                            @if (config('advertisements_active') and config('media_index_page_main_ad_slot'))
                                <div id="block" class="card">
                                    @include("components.responsive_ad")
                                </div>
                            @endif

                            <!-- Media and details -->
                            <div class="card no-margin-top">
                                <div class="card-block">
                                    <h5>{{ $media->title }}</h5>
                                    @if($media->type == 'picture')
                                        <ul class="image-gallery">
                                            <li data-thumb="{{ $media->previewImageUrl() }}"
                                                data-src="{{ $media->previewImageUrl('original') }}">
                                                <img src="{{ $media->previewImageUrl('original') }}" alt="thumb">
                                            </li>
                                            @if(is_array($media->isGallery()))
                                                @foreach($media->isGallery()['file_paths'] as $key => $file_path)
                                                    @if($file_path && url($file_path) != $media->previewImageUrl('original'))
                                                        <li data-thumb="{{ url($media->isGallery()['file_paths_thumb'][$key]) }}"
                                                            data-src="{{ url($file_path) }}">
                                                            <img src="{{ url($file_path) }}" alt="thumb">
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </ul>
                                    @elseif ($media->type == 'video')
                                        <video
                                            id="media"
                                            class="video-js vjs-big-play-centered"
                                            poster="{{ $media->previewImageUrl() }}"
                                        >
                                            <source class="download_url" src="{{ $download_url }}" type="video/{{ $media->streamExtension('video') }}">
                                            <p class="vjs-no-js">
                                                {{ trans('media_index.enable_js_video') }}
                                                <a href="http://browsehappy.com/" target="_blank">{{ trans('media_index.support_html5_video') }}</a>
                                            </p>
                                        </video>
                                    @elseif ($media->type == 'audio')
                                        <div class="row no-margins">
                                            <audio
                                                id="media"
                                                class="video-js vjs-default-skin col-md-12 col-sm-12 col-xs-12"
                                                preload="auto">

                                                <source class="download_url" src="{{ $download_url }}" type="audio/{{ $media->streamExtension('audio') }}">
                                                <p class="vjs-no-js">
                                                    {{ trans('media_index.enable_js_audio') }}
                                                    <a href="http://browsehappy.com/" target="_blank">{{ trans('media_index.support_html5_audio') }}</a>
                                                </p>
                                            </audio>
                                        </div>
                                    @else
                                        @if ($media->streamExtension('others') == 'pdf' || $media->streamExtension('others') == 'epub')
                                            <object data="{{ $download_url }}" type="application/{{ $media->streamExtension('others') }}" width="100%" height="500">
                                                <p><a href="{{ $download_url }}">{{ trans('media_index.view_the_pdf') }}</a></p>
                                            </object>
                                        @elseif ($media->isFont())
                                            <div class="uploaded-font">
                                                <hr>
                                                <p class="lead">Example Text:</p>
                                                <span>Roger, hungry: ate 236 peaches & cantaloupes in 1904!</span><br><br><br>
                                                <span>ABCDEFGHIJKLMNOPQRSTUVXYZ</span><br>
                                                <span>abcdefghijklmnopqrstuvwxyz</span><br>
                                                <span>0123456789</span><br>
                                                <span>¿ ? ¡ ! & @ ‘ ’ “ ” « » % * ^ # $ £ € ¢ / ( ) [ ] { } . , ® ©</span>
                                            </div>
                                        @else
                                            <div class="file-type-na">
                                                <img src="{{ url('assets/images/filetype-na.png') }}" alt="thumb">
                                                <p class="subtitle" style="margin-top: 25px"><strong>{{ $media->streamExtension('others') }}. {{ trans('media_index.cant_preview_files') }}</strong></p>
                                            </div>
                                        @endif
                                    @endif
                                    @if($media->body != '')
                                        <hr>
                                        {!! $media->body !!}
                                    @endif
                                    <hr>
                                    <div class="bottom-nav">
                                        @if ($media->type == 'audio' || $media->type == 'video'  || $media->type == 'picture')
                                            <div data-toggle="collapse" href="#collapse"  class="btn btn-xs btn-info expand">
                                                <i class="fa fa-code"></i> {{ trans('media_index.share') }}
                                            </div>
                                            <div class="btn btn-xs btn-white lights hidden">
                                                <i class="fa fa-lightbulb-o"></i>
                                            </div>
                                        @endif
                                        <div class="pull-right">
                                            @if ($owner || $admin)
                                                <a href="{{ route('media.edit', $media->slug) }}" class="btn btn-xs btn-primary text-sm" alt="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endif
                                            <button class="btn btn-xs btn-danger text-sm flag" data-id="{{ $media->id }}" data-type="media" alt="Report">
                                                <i class="fa fa-flag"></i>
                                            </button>
                                            @if (config('downloadable') && $media->downloadable)
                                                <a class="btn btn-xs btn-success download_url" href="{{ $download_url }}" alt="Download" download>
                                                    <i class="fa fa-download"></i>
                                                </a>
                                            @endif
                                            <i class="file-size-display">{{ $media->humanFileSize() }}</i>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <!-- END Media and details -->
                            <div id="collapse" class="card panel-collapse collapse">
                                <div class="card-header">
                                    <h6>{{ trans('media_index.share') }}</h6>
                                </div>

                                <div class="form-horizontal">
                                    <fieldset>
                                        <p style="margin-left: 30px; margin-top: 30px; margin-bottom: 15px;"><strong>{{ trans('media_index.direct_links') }}:</strong></p>

                                        @if ($media->type == 'picture')
                                            <div class="form-group">
                                                <label class="col-md-3 control-label" for="image-url">{{ trans('media_index.image_url') }}</label>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control input-md" value="{{ $media->previewImageUrl('original') }}">
                                                </div>
                                            </div>
                                        @else
                                            <div class="form-group">
                                                <label class="col-md-3 control-label" for="embed-code">{{ trans('media_index.embed_code') }}</label>
                                                <div class="col-md-7">
                                                    <textarea class="form-control input-md"><iframe src="{{ url('embed/'.$media->key) }}" scrolling="no" frameborder="0" width="700" height="430" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe></textarea>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="short-link">{{ trans('media_index.short_link') }}</label>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control input-md" value="{{ $media->getShortUrl() }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="full-link">{{ trans('media_index.full_link') }}</label>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control input-md" value="{{ $media->getFullUrl() }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="thumbnail-url">{{ trans('media_index.thumbnail_url') }}</label>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control input-md" value="{{ $media->previewImageUrl() }}">
                                            </div>
                                        </div>

                                        @if ($media->type == 'picture')
                                            <p style="margin-left: 30px; margin-top: 30px; margin-bottom: 15px;"><strong>{{ trans('media_index.full_image') }}:</strong></p>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label" for="html">{{ trans('media_index.html') }}</label>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control input-md" value='<img src="{{ $media->previewImageUrl('original') }}" alt="{{ $media->title }}" border="0" />'>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label" for="bbcode">{{ trans('media_index.bbcode') }}</label>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control input-md" value="[img]{{ $media->previewImageUrl('original') }}[/img]">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label" for="markdown">{{ trans('media_index.markdown') }}</label>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control input-md" value="![{{ $media->title }}]({{ $media->previewImageUrl('original') }})">
                                                </div>
                                            </div>
                                        @endif

                                        <p style="margin-left: 30px; margin-top: 30px; margin-bottom: 15px;"><strong>{{ trans('media_index.thumbnail_image') }}:</strong></p>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="html">HTML</label>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control input-md" value='<img src="{{ $media->previewImageUrl() }}" alt="{{ $media->title }}" border="0" />'>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="bbcode">BBCode</label>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control input-md" value="[img]{{ $media->previewImageUrl() }}[/img]">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="markdown">Markdown</label>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control input-md" value="![{{ $media->title }}]({{ $media->previewImageUrl() }})">
                                            </div>
                                        </div>

                                        <br><br>
                                    </fieldset>
                                </div>
                            </div>

                            @if (config('comments_active') && $media->commentable)
                                @if (! config('disqus'))
                                    <!-- Comments -->
                                    <div id="comments" class="card">
                                        <div class="card-header">
                                            <h6>{{ trans('media_index.comments') }} ({{ $media->comments->count() }})</h6>
                                        </div>

                                        <ul class="comments">
                                            @foreach($media->commentsMostLikes as $comment)
                                                @if($comment->approved == false)
                                                    <li id="comment-{{ $comment->id }}">

                                                        <a href="{{ route('user.profile.index', !empty($comment->user->username) ? $comment->user->username : 'Guest') }}">
                                                            <img src="{{ getAvatarUrl(!empty($comment->user->id) ? $comment->user->id : 1) }}" alt="">
                                                        </a>
                                                        <h6>
                                                            <a href="{{ route('user.profile.index', !empty($comment->user->username) ? $comment->user->username : 'Guest') }}">{{ !empty($comment->user->username) ? $comment->user->username : 'Guest' }}</a>
                                                            <time class="pull-right">{{ $comment->created_at->diffForHumans() }}</time>
                                                        </h6>
                                                        <p>{{ $comment->body }}
                                                            <br>
                                                            <div style="margin-left: 10px;" class="pull-right text-sm text-red flag" data-id="{{ $comment->id }}" data-type="comment">
                                                                <i class="fa fa-flag"></i>
                                                            </div>
                                                        </p>

                                                        <div class="likes" data-type="comment">
                                                            <span data-id="{{ $comment->id }}" class="like {{ ($comment->liked() ? 'liked' : '' ) }}"></span>
                                                            <b class="likes_counter">{{ $comment->likeCount}}</b>
                                                        </div>
                                                        {{--<div class="likes">--}}
                                                            {{--<span data-id="{{ $media_item->id }}" class="like {{ ($media_item->liked() ? 'liked' : '') }}"></span>--}}
                                                            {{--<span class="likes_counter">{{ $media_item->readableCount('likes') }}</span>--}}
                                                        {{--</div>--}}

                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                        <form class="comment-form" method="post" action="{{ route('media.add.comment') }}">
                                            @if(Auth::check())
                                                {{ method_field('put') }}
                                                {{ csrf_field() }}
                                                {{ Form::hidden('media_id', $media->id) }}
                                                <img src="{{ getAvatarUrl( Auth::user()->id ) }}" alt="">
                                                <p><input type="text" class="form-control" name="body" placeholder="{{ trans('media_index.leave_a_comment') }}"></p>
                                            @else
                                                <h5>{{ trans('media_index.please') }} <a class="txt-blue" href="{{ url('login') }}"> {{ trans('media_index.login') }}</a> {{ trans('media_index.to_leave_a_comment') }} </h5>
                                            @endif
                                        </form>

                                    </div>
                                    <!-- END Comments -->
                                @else
                                    {!! config('disqus') !!}
                                @endif
                            @endif

                        </div>

                        <aside class="col-xs-12 col-md-4 shot-sidebar">

                            <!-- Media stats -->
                            <div class="sidebar-block">
                                <ul class="single-shot-stats">
                                    <li>
                                        <div class="likes" data-type="media">
                                            <span data-id="{{ $media->id }}" class="like {{ ($media->liked() ? 'liked' : '') }}"></span>
                                            <span class="likes_counter">{{ $media->readableCount('likes') }}</span>
                                        </div>
                                    </li>
                                    <li><i class="fa fa-eye"></i><span>{{ $media->readableCount('views') }}</span></li>
                                    <li><a  href="#"><i class="fa fa-comments"></i><span>{{ $media->readableCount('comments') }}</span></a></li>
                                </ul>
                            </div>
                            <!-- END Media stats -->

                            <!-- Share -->
                            <div class="sidebar-block">
                                <h6>{{ trans('media_index.share_on') }}</h6>
                                <ul class="social-icons text-center">
                                    <li><a class="facebook" href="{{ $media->socialLinks()['facebook'] }}"><i class="fa fa-facebook"></i></a></li>
                                    <li><a class="google-plus" href="{{ $media->socialLinks()['gplus'] }}"><i class="fa fa-google-plus"></i></a></li>
                                    <li><a class="twitter" href="{{ $media->socialLinks()['twitter'] }}"><i class="fa fa-twitter"></i></a></li>
                                    <li><a class="tumblr" href="{{ $media->socialLinks()['tumblr'] }}"><i class="fa fa-tumblr"></i></a></li>
                                    <li><a class="pinterest" href="{{ $media->socialLinks()['pinterest'] }}"><i class="fa fa-pinterest"></i></a></li>
                                    <li><a class="delicious" href="{{ $media->socialLinks()['delicious'] }}"><i class="fa fa-delicious"></i></a></li>
                                    <li><a class="digg" href="{{ $media->socialLinks()['digg'] }}"><i class="fa fa-digg"></i></a></li>
                                    <li><a class="reddit" href="{{ $media->socialLinks()['reddit'] }}"><i class="fa fa-reddit"></i></a></li>
                                    <li><a class="send" href="{{ $media->socialLinks()['email'] }}"><i class="fa fa-send"></i></a></li>
                                </ul>
                            </div>
                            <!-- END Share -->

                            <!-- User widget -->
                            <div class="sidebar-block">
                                <div class="shot-by-widget">
                                    @if(! $anonymous)
                                        <a href="{{ route('user.profile.index', $user->username) }}"><img src="{{ getAvatarUrl($user->id ) }}" alt="avatar"></a>
                                        <a class="username" href="{{ route('user.profile.index', $user->username ) }}">{{ $user->username }}</a>
                                        <p class="title"><i class="fa fa-star"></i> {{ trans('profile.points') }}: {{ \App\User::find($user->id)->pointsSum() }}</p>
                                        <p class="subtitle">{{ trans('profile.member_since') }}: {{ $user->created_at->toFormattedDateString() }}</p>

                                        <ul class="user-stats">
                                            <li><a href="{{ route('user.profile.index', $user->username ) }}"><i>{{ trans('media_index.media_uploads') }}</i><span>{{ \App\User::find($user->id)->media->count() }}</span></a></li>
                                            <li><a href="{{ route('user.profile.followers', $user->username) }}"><i>{{ trans('profile.followers') }}</i><span>{{ \App\User::find($user->id)->followers->count() }}</span></a></li>
                                            <li><a href="{{ route('user.profile.following', $user->username) }}"><i>{{ trans('profile.following') }}</i><span>{{ \App\User::find($user->id)->following->count() }}</span></a></li>
                                        </ul>
                                    @else
                                        <a><img src="{{ url('uploads/avatars/default-avatar.png') }}" alt="anonymous"></a>
                                        <a class="username">{{ trans('media_index.anonymous') }}</a>
                                    @endif
                                    @if(Auth::check())
                                        @if($owner)
                                            <a class="btn btn-primary btn-sm" href="{{ route('settings.profile') }}">{{ trans('profile.edit_profile') }}</a>
                                        @else
                                            @if(Auth::user()->isFollow($user->id))
                                                <button data-id="{{ $user->id }}" class="follow btn btn-default btn-sm" href="#">{{ trans('profile.unfollow') }}</button>
                                            @else
                                                @if (! $anonymous)
                                                    <button data-id="{{ $user->id }}" class="follow btn btn-success btn-sm" href="#">{{ trans('profile.follow') }}</button>
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <!-- END User widget -->

                        @if($media->tags->count())
                            <!-- Tags -->
                            <div class="sidebar-block">
                                <h6>Tags</h6>
                                <div class="tag-list">
                                    @foreach($media->tags as $tag)
                                        <a href="{{ route('tag.show', $tag->slug) }}">{{$tag->name}}</a>
                                    @endforeach
                                </div>
                            </div>
                            <!-- END Tags -->
                        @endif

                        @if (config('advertisements_active') and config('media_index_page_sidebar_ad_slot'))
                            <div class="sidebar-block">
                                <center>
                                    {!! config('media_index_page_sidebar_ad_slot') !!}
                                </center>
                            </div>
                        @endif

                        @if(! $anonymous)
                            @if($media->userOtherMedia($user->id, $media->id)->count())
                                <!-- More shots -->
                                    <div class="sidebar-block">
                                        <h6>More from {{ $user->username }}</h6>
                                        <ul class="photo-list cols-2">
                                            @foreach($media->userOtherMedia($user->id, $media->id) as $user_media)
                                                <li style="position: relative">
                                                    <a href="{{ url('m/'.$user_media->key) }}">
                                                        @if ($user_media->type == "video" || $user_media->type == "audio")
                                                            <span class="play-sidebar fa fa-play" id="{{ $user_media->type }}"></span>
                                                        @endif
                                                        <img src="{{ $user_media->previewImageUrl() }}" alt="{{ $user_media->title }}" style="{{ $user_media->maxHeightOrWidth($user_media->previewImageUrl('thumbnail-l')) }}">
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <!-- END More shots -->
                                @endif
                            @endif

                        </aside>
                    </div>
                @else

                    <div class="row">
                        <div class="col-xs-12 col-md-8 col-md-offset-2">
                            <!-- Ask for password -->
                            <div class="card no-margin-top">
                                <div class="card-block">
                                    <h5>{{ trans('media_index.enter_the_password') }}</h5>
                                    <form method="post" action="{{ route('media.password.check', $media->slug) }}">
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="media-password">{{ trans('settings.password') }}</label>
                                                <input type="password" class="form-control" id="media-password" placeholder="{{ trans('settings.password') }}" name="media-password">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p>{{ trans('media_index.password_protected') }}</p>
                                                <button type="submit" class="btn btn-primary">{{ trans('media_index.submit') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- END Password -->

                        </div>
                    </div>

                @endif

            </div>
        </section>

    </main>
    <!-- END Main container -->

@endsection

@section('scripts')
    @include('components.media_scripts', ['media' => $media, 'view' => 'index'])

    @if ($media->type == 'video' || $media->type == 'audio')
        @include('components.videojs_player', ['view' => 'index'])
    @endif

    <script>
        {{--@if (str_contains($media->cloned, 'openload'))--}}
            {{--setTimeout(function() {--}}
                {{--$('.vjs-modal-dialog-content').html('<center>We are currently processing your request to watch this video. Hang tight. <br><br><br><img src="{{ url('assets/images/loading.gif') }}"></center>');--}}
                {{--$('.vjs-error-display').removeClass('vjs-error-display');--}}
            {{--}, 1);--}}

            {{--function testAjax(handleData) {--}}
                {{--const data = {--}}
                    {{--_token:"{{ csrf_token() }}",--}}
                {{--};--}}

                {{--$.ajax({--}}
                    {{--type: "POST",--}}
                    {{--data: data,--}}
                    {{--url: "{{ route('media.get.openload', $media->key) }}",--}}
                    {{--success: function(data) {--}}
                        {{--handleData(data);--}}
                    {{--}--}}
                {{--});--}}
            {{--}--}}

            {{--testAjax(function(output){--}}
                {{--// console.log('output is '+output);--}}
                {{--// here you use the output--}}
            {{--});--}}
        {{--@endif--}}

        // flag / report
        $('.flag').on('click',function(){

            const type = $(this).data('type');
            const id = $(this).data('id');

            swal({
                title: "{{ trans('media_index.report_this') }} "+ type +"!",
                text: "{{ trans('media_index.what_reason') }}",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                inputPlaceholder: "{{ trans('media_index.write_something') }}",
                showLoaderOnConfirm: true,

            }, function(inputValue){
                if (inputValue === false) return false;

                if (inputValue === "") {
                    swal.showInputError("{{ trans('media_index.need_to_write_something') }}");
                    return false
                }

                const data = {
                    _token: "{{ csrf_token() }}",
                    type: type,
                    flagged_id: id,
                    reason: inputValue,
                };
                const url_flag = "{{ route('media.flag') }}";

                $.ajax({
                    url: url_flag,
                    type: "POST",
                    data: data,
                    success: function(){
                        swal("{{ trans('media_index.reported') }}", "{{ trans('media_index.report_sent') }}", "success", true);
                    },error: function(){
                        swal("{{ trans('manage_media.error') }}", "{{ trans('media_index.cant_flag') }}", "error");
                    }
                }); //end of ajax
            });
        });

        $(document).on('click', '.likes', function(){

            if(auth === false){
                window.location = "{{ url('login') }}";
            }

            var likes = this;

            if($(likes).data('type') === 'comment'){

                $.ajax({
                    url: "{{ route('media.comment.like') }}",
                    method: "PUT",
                    type: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: $(likes).find('.like').data('id'),
                    },
                    success: function(data) {
                        $(likes).find('.likes_counter').text(data);
                        $(likes).find('.like').toggleClass("liked");
                    }
                });
            }

            if($(likes).data('type') === 'media'){

                $.ajax({
                    url: "{{ route('media.like') }}",
                    method: "PUT",
                    type: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: $(likes).find('.like').data('id'),
                    },
                    success: function(data) {
                        $(likes).find('.likes_counter').text(data);
                        $(likes).find('.like').toggleClass("liked");
                    }
                });
            }

        });

    </script>
    @if ($media->type == 'audio' || $media->type == 'video')
        <script>
            $('.lights').on('click',function(){
                $('<div id="lightsOut"></div>').appendTo('body');

                $('#lightsOut').css({
                    opacity: 0,
                    width: $(document).width(),
                    height: $(document).height()
                })
                    .addClass('lightsOut')
                    .animate({opacity: 1}, 400);

                $('#media').css({
                    "z-index": "10001",
                    "position": "relative"
                }).show();
            });
        </script>
    @endif
@endsection