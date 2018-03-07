@extends('layouts.app', ['title' => 'Login'])

@section('content')

<!-- Main container -->
<main>
    <section class="no-border-bottom section-sm">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-lg-6 col-lg-offset-3">

                    @if (config('social_keys_active'))
                        <div class="card">
                            <div class="card-block">
                                <h6 class="text-uppercase no-margin-top"><small>Login with</small></h6>
                                <div class="row">
                                    @if (config('facebook_client_id') and config('facebook_client_secret'))
                                        <div class="col-xs-6">
                                            <a class="btn btn-facebook btn-sm btn-block" href="{{ route('redirect','facebook') }}"><i class="fa fa-facebook"></i> Facebook</a>
                                        </div>
                                    @endif

                                    @if (config('twitter_client_id') and config('twitter_client_secret'))
                                        <div class="col-xs-6">
                                            <a class="btn btn-twitter btn-sm btn-block" href="{{route('redirect','twitter')}}"><i class="fa fa-twitter"></i> Twitter</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <h6>Sign in</h6>
                        </div>

                        <div class="card-block">
                            <br>
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                                    <input class="form-control input-lg" type="email" name="email" placeholder="Email" required>

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                </div>


                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                                    <input class="form-control input-lg" name="password" type="password" placeholder="Password" required>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                </div>

                                <button class="btn btn-primary btn-block" type="submit">Login</button>
                            </form>
                            <br>
                        </div>

                        <div class="card-footer">
                            <div class="row text-center">
                                <div class="col-xs-6">
                                    <a href="{{ url('register') }}">Register</a>
                                </div>

                                <div class="col-xs-6">
                                    <a href="{{ url('password/reset') }}">Forget password?</a>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>

</main>
<!-- END Main container -->

@endsection
