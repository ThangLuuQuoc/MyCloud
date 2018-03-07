@extends('layouts.app', ['title' => 'Contact us'])

@section('content')

<!-- Main container -->
<main>

    <!-- Contact -->
    <section class="bg-white">
        <div class="container">
            <header class="section-header">
                <h2>Contact us</h2>
            </header>
            <div class="card col-sm-12 col-md-8 col-md-offset-2">
                <div class="card-header">
                    <h6>Write us a message</h6>
                </div>

                @include('components.error_notification')

                @include('components.flash_notification')

                <div class="card-block">
                    <form id="contact-form" method="post" action="{{ route('contact.post.message') }}">
                        {{ csrf_field() }}
                        <input name="name" type="text" value="{{ old('name') }}" class="form-control input-lg" placeholder="Name">
                        <br>
                        <input name="email" type="email" value="{{ old('email') }}" class="form-control input-lg" placeholder="Email">
                        <br>
                        <input name="title" type="text" value="{{ old('title') }}" class="form-control input-lg" placeholder="Subject">
                        <br>
                        <textarea name="message" class="form-control" rows="5" placeholder="Message">{{ old('message') }}</textarea>
                        <br>
                        @if (config('captcha_active'))
                            {!! app('captcha')->display($attributes = ['data-badge' => 'bottomleft', 'data-callback' => 'onSubmit']) !!}
                        @else
                            <button type="submit" onclick="prop('disabled', true);" class="btn btn-primary btn-lg">Send</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- END Contact -->
</main>
@endsection

@section('scripts')
    @if (config('captcha_active'))
        <script>
            $(".g-recaptcha").addClass("btn btn-primary btn-lg").html("Send");

            function onSubmit(token) {
                $("#contact-form").submit();
                $(".g-recaptcha").prop("disabled", true);
            }
        </script>
    @endif
@endsection
