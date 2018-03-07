@extends('layouts.app', ['title' => $user->username])

@section('styles')
@endsection

@section('content')
<!-- Main container -->
<main>

    <!-- Profile head -->
    <div class="profile-head">
        <div class="container">

            @include('components.flash_notification')

            <img src="{{ getAvatarUrl($user->id) }}" alt="avatar">
            <h5><a href="{{ route('user.profile.index',$user->username) }}">{{ $user->username }}</a></h5>
            <p class="lead"><i class="fa fa-star text-danger"></i> {{ trans('profile.points') }}: {{ $user->pointsSum() }}</p>
            <p>{{ trans('profile.member_since') }}: {{ $user->created_at->toFormattedDateString() }}</p>
            @if(Auth::id() == $user->id)
                <p class="small">{{ trans('profile.account_status') }}: <strong>{{ trans('profile.unlimited_premium_account') }}</strong></p>
            @endif

            <div class="row bottom-bar">
                @if(Auth::check())
                    <ul class="col-sm-12 col-md-6 action-buttons">
                    @if($owner)
                        <li><a class="btn btn-primary btn-sm" href="{{ route('settings.profile') }}">{{ trans('profile.edit_profile') }}</a></li>
                    @else
                        @if(Auth::user()->isFollow($user->id))
                        <li><button data-id="{{ $user->id }}" class="follow btn btn-default btn-sm" href="#">{{ trans('profile.unfollow') }}</button></li>
                        @else
                        <li><button data-id="{{ $user->id }}" class="follow btn btn-success btn-sm" href="#">{{ trans('profile.follow') }}</button></li>
                        @endif
                    @endif
                    </ul>
                @endif
                <ul class="col-sm-12 col-md-6 tab-list">
                    <li class="{{ ($page == 'index') ? 'active' : '' }}">
                        <a href="{{ route('user.profile.index', $user->username) }}"><i>{{ trans('profile.media') }}</i>
                            <span>
                                {{ $user->media->count() }}
                            </span>
                        </a></li>
                    <li class="{{ ($page == 'likes') ? 'active' : 'hidden-xs' }}">
                        <a href="{{ route('user.profile.likes', $user->username) }}"><i>{{ trans('profile.likes') }}</i>
                            <span>
                                {{ \App\Media::whereLikedBy ($user->id)->count() }}
                            </span>
                        </a>
                    </li>
                    <li class="{{ ($page == 'followers') ? 'active' : '' }}" >
                        <a href="{{ route('user.profile.followers',$user->username) }}">
                            <i>{{ trans('profile.followers') }}</i><span id="followers_count">{{ $user->followers->count() }}
                            </span>
                        </a>
                    </li>
                    <li class="{{ ($page == 'following') ? 'active' : '' }}" >
                        <a href="{{ route('user.profile.following', $user->username) }}">
                            <i>{{ trans('profile.following') }}</i><span>{{ $user->following->count() }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- END Profile head -->

    @if($page == 'likes' || $page == 'index')
        @include('components.profile_media')
    @endif

    @if($page == 'followers' || $page == 'following')
        @include('components.profile_followers')
    @endif
</main>
<!-- END Main container -->
@endsection

@section('scripts')
    <script>
        $('.shot-preview a').on('click',function(){
            window.location = $(this).attr('href');
        });

    </script>
@endsection
