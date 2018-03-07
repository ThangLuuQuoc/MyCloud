@php
    $agent = new Jenssegers\Agent\Agent();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $website_desc }}">
    <meta name="keywords" content="{{ $website_keywords }}">

    @if( Request::is( Config::get('chatter.routes.home')) )
        <title>{{ config('website_title', null) }} | Forums</title>
        <meta property="og:title" content="{{ config('website_title', null) }} | Forums"/>
    @elseif( Request::is( Config::get('chatter.routes.home') . '/' . Config::get('chatter.routes.category') . '/*' ) && isset( $discussion ) )
        <title>{{ config('website_title', null) }} | {{ $discussion->category->name }}</title>
        <meta property="og:title" content="{{ config('website_title', null) }} | {{ $discussion->category->name }}"/>
    @elseif( Request::is( Config::get('chatter.routes.home') . '/*' ) && isset($discussion->title))
        <title>{{ config('website_title', null) }} | {{ $discussion->category->name }} - {{ $discussion->title }}</title>
        <meta property="og:title" content="{{ config('website_title', null) }} | {{ $discussion->category->name }} - {{ $discussion->title }}"/>
    @else
        <title>{{ config('website_title', null) . (isset($title) ? ' | ' . $title : "") }}</title>
    @endif

    <!-- OG for Social Media -->
    @if (! Request::is('media/*') && ! Request::is('m/*'))
        <meta property="og:title" content="{{ config('website_title', null) . (isset($title) ? ' | ' . $title : "") }}"/>
        <meta property="og:image" content="{{ url('assets/images/social.png') }}"/>
        <meta property="og:site_name" content="{{ config('website_title', null) }} Media"/>
        <meta property="og:description" content="{{ $website_desc }}"/>

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ config('website_title', null) . (isset($title) ? ' | ' . $title : "") }}">
        <meta name="twitter:description" content="{{ $website_desc }}">
        <meta name="twitter:image" content="{{ url('assets/images/social.png') }}">
    @endif

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ url('assets/css/theshots.css') }}" rel="stylesheet">
    <link href="{{ url('assets/css/skins/skin-'.config("theme").'.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/css/themify-icons.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{url('assets/css/style.css')}}" rel="stylesheet">
    <link href="{{url('assets/css/pnotify.custom.min.css')}}" rel="stylesheet">

    @yield('styles')

    @if(Request::is( Config::get('chatter.routes.home') ) || Request::is( Config::get('chatter.routes.home') . '/*' ))
        <!-- Chatter Modification -->
        <link href="{{url('assets/css/chatter-mod.css')}}" rel="stylesheet">
    @endif

    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Raleway:100,300,400,500,600,800%7COpen+Sans:300,400,500,600,700,800%7CMontserrat:400,700' rel='stylesheet' type='text/css'>

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="144x144" href="{{url('assets/images/favicons/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" href="{{url('assets/images/favicons/favicon.png')}}" sizes="32x32">
    <link rel="manifest" href="{{url('assets/images/favicons/manifest.json')}}">
    <link rel="mask-icon" href="{{url('assets/images/favicons/safari-pinned-tab.svg')}}" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">

    @if (config('analytics_active'))
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', '{{ ! empty (config('google_analytics_id')) ? config('google_analytics_id') : '' }}', 'auto');
            ga('send', 'pageview');
        </script>
    @endif

</head>

<body class="sticky-nav">

<!-- Navigation bar -->
<nav class="navbar">
    <div class="container">

        <!-- Logo and navigation links -->
        <div class="pull-left">
            <a class="navbar-toggle" href="#" data-toggle="offcanvas"><i class="fa fa-bars"></i></a>

            <div class="logo">
                <a href="{{ route('home') }}"><img src="{{ url('assets/images/logo.png') }}" alt="logo"></a>
            </div>

            <ul class="nav-menu">
                <li>
                    <a href="{{ route('home') }}"><i class="fa fa-home"></i> {{ trans('header.home') }}</a>
                </li>
                @if( Auth::check() )
                    <li>
                        <a href="{{ route('follow.feeds') }}"><i class="fa fa-list"></i> {{ trans('header.follow_feed') }}</a>
                    </li>
                @endif
                @if(App\Category::count())
                    <li>
                        <a href="#"><i class="fa fa-folder-o"></i> {{ trans('header.categories') }}</a>
                        <ul>
                            @foreach(App\Category::order() as $category)
                                <li><a href="{{ route('category.show', $category->slug) }}"><i class="fa {{ $category->icon }} text-left"></i> {{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @endif
                @if(App\Page::order()->count())
                    <li>
                        <a href="#"><i class="fa fa-files-o"></i> {{ trans('header.pages') }}</a>
                        <ul>
                            @foreach(App\Page::order() as $page)
                                <li><a href="{{ route('page.show', $page->slug) }}"><i class="fa {{ $page->icon }} text-left"></i> {{ $page->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @endif
                <li>
                    <a href="{{ route('chatter.home') }}"><i class="fa fa-envelope-o"></i> {{ trans('header.forums') }}</a>
                </li>
            </ul>
        </div>
        <!-- END Logo and navigation links -->

        <!-- User account and action buttons -->
        @if(Auth::check())
            <div class="pull-right">

                <a class="btn-navbar" href="{{ route('upload') }}"><i class="fa fa-cloud-upload"></i></a>
                <a class="btn-navbar search-opener" href="#"><i class="ti-search"></i></a>

                <div class="dropdown user-account">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <img src="{{ getAvatarUrl(Auth::user()->id) }}" alt="avatar">
                    </a>

                    <ul class="dropdown-menu dropdown-menu-right">
                        @if(Auth::user()->type == 'admin')
                            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-gears"></i> {{ trans('header.admin_panel') }}</a></li>
                        @endif
                        @if (Auth::check())
                            <li><a href="{{ route('manage.index') }}"><i class="fa fa-paper-plane"></i> {{ trans('header.file_manager') }}</a></li>
                        @endif
                        <li><a href="{{ route('user.profile.index', Auth::user()->username) }}"><i class="fa fa-user"></i> {{ trans('header.profile') }}</a></li>
                        @php
                            $status = 0;
                            $affiliate = \App\Affiliate::where('user_id', Auth::id())->first();
                            if (! empty($affiliate)) {
                                $status = $affiliate->status;
                            }
                        @endphp
                        @if($status == 1)
                            <li><a href="{{ route('affiliate.statistics') }}"><i class="fa fa-briefcase"></i> {{ trans('header.affiliate') }}</a></li>
                        @endif
                        <li><a href="{{ route('settings.profile') }}"><i class="fa fa-gear"></i> {{ trans('header.settings') }}</a></li>
                        <li>
                            <a href="{{ url('/logout') }}"
                               onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                                 <i class="fa fa-sign-out"></i> {{ trans('header.logout') }}
                            </a>

                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        @else
            <div class="pull-right">
                @if ($agent->isMobile())
                    <a class="btn-navbar" href="{{ route('login') }}" style="margin-top: 15px;"><i class="fa fa-sign-in"></i></a>
                    <a class="btn-navbar" href="{{ route('register') }}" style="margin-top: 15px;"><i class="fa fa-user-plus"></i></a>
                @else
                    <ul class="quick-links">
                        @if (config('guest_uploads'))
                            <a class="btn-navbar" href="{{ route('upload') }}"><i class="fa fa-cloud-upload"></i></a>
                        @endif
                        <a class="btn-navbar" href="{{ route('login') }}"><i class="fa fa-sign-in"></i></a>
                        <a class="btn-navbar" href="{{ route('register') }}"><i class="fa fa-user-plus"></i></a>
                    </ul>
                @endif
            </div>
        @endif
        <!-- END User account and action buttons -->
        <!-- Search screen -->
        <div class="search-screen closed">
            <button class="search-closer"><i class="fa fa-close"></i></button>
            <form class="search-form" action="{{ route('search') }}" method="get">
                <input type="text" name="q" autocomplete="off" placeholder="{{ trans('header.search') }}">
            </form>
        </div>
        <!-- END Search screen -->

    </div>
</nav>
<!-- END Navigation bar -->

@yield('content')

<!-- Site footer -->
<footer class="site-footer">

    <!-- Bottom section -->
    <div class="container">
        <div class="row">
            @if(App\Page::orderFooter(0)->count())
                @foreach(App\Page::orderFooter(0) as $parent)
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        @if ($parent->name == 'Social Media')
                            <ul class="social-icons">
                                @php
                                    $social_links = Share::load(url('/'), config("website_title"))->services('gplus', 'facebook', 'twitter', 'reddit', 'email');
                                @endphp
                                <li><a class="facebook" href="{{ ! empty(config('facebook')) ? config('facebook') : $social_links['facebook'] }}"><i class="fa fa-facebook"></i></a></li>
                                <li><a class="twitter" href="{{ ! empty(config('twitter')) ? config('twitter') : $social_links['twitter'] }}"><i class="fa fa-twitter"></i></a></li>
                                @if (! empty(config('instagram')))
                                    <li><a class="instagram" href="{{ config('instagram') }}"><i class="fa fa-instagram"></i></a></li>
                                @endif
                                <li><a class="google-plus" href="{{ $social_links['gplus'] }}"><i class="fa fa-google-plus"></i></a></li>
                                <li><a class="reddit" href="{{ $social_links['reddit'] }}"><i class="fa fa-reddit"></i></a></li>
                                <li><a class="send" href="{{ $social_links['email'] }}"><i class="fa fa-send"></i></a></li>
                            </ul>
                        @else
                            <h5>{{ $parent->name }}</h5>
                            <ul class="footer-links">
                                @foreach(App\Page::orderFooter($parent->id) as $page)
                                    <li><a class="" href="{{ route('page.footer.show', [$parent->slug, $page->slug]) }}">{{ $page->name }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <!-- END Bottom section -->

</footer>
<!-- END Site footer -->

<!-- Back to top button -->
<a id="scroll-up" href="#"><i class="fa fa-angle-up"></i></a>
<!-- END Back to top button -->

<!-- Scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="{{ url('assets/js/lightslider.min.js') }}"></script>
<script src="{{ url('assets/js/smoothscroll.min.js') }}"></script>
<script src="{{ url('assets/js/theshots.js') }}"></script>
<script src="{{ url('assets/js/matchHeight.min.js') }}"></script>
<script src="{{ url('assets/js/custom.js') }}"></script>
<script src="{{ url('assets/js/pnotify.custom.min.js') }}"></script>
<script>var blockAdBlock = undefined;</script>
<script src="{{ url('assets/js/blockadblock.js') }}"></script>
<script>
    var auth = "{{ Auth::check() }}";

    $('.follow').on('click',function() {

        $(this).toggleClass('btn-success');

            if($(this).text() == '{{ trans('profile.unfollow') }}') {
                $(this).text('{{ trans('profile.follow') }}')
            } else if($(this).text() == '{{ trans('profile.follow') }}'){
                $(this).text('{{ trans('profile.unfollow') }}')
            }

        $.ajax({
            url: "{{ route('follow') }}",
            method: "PUT",
            type: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                id: $(this).data('id'),
            },
            success:function (data){
                //$('#followers_count').text(data)
                //$(likes).find('.likes_counter').text(data);
            }
        });
    });

</script>

@yield('scripts')

</body>
</html>
