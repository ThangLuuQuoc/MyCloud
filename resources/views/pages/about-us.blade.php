@extends('layouts.app', ['title' => 'About Us'])

@section('content')

    <!-- Main container -->
    <main>

        <!-- Team -->
        <section class="no-border-bottom">
            <div class="container">
                <header class="section-header">
                    <span>Who we are</span>
                    <h2>Our team</h2>
                    <p>Currently, we're three geeks and will grow up soon</p>
                </header>

                <div class="row equal-blocks">

                    <!-- User widget -->
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="card user-widget">
                            <div class="card-block text-center">
                                <a href="https://clooud.tv/user/Chris"><img src="https://clooud.tv/uploads/avatars/chris.jpg" alt="Chris"></a>
                                <h5><a href="#">Chris Breuer</a></h5>
                                <p class="lead">Founder</p>
                                <br>
                                <p class="text-justify">Got annoyed by all the annoying websites throwing 20 popups each, so he figured he can do better.</p>
                            </div>

                            <div class="card-footer">
                                <ul class="social-icons">
                                    <li><a class="twitter" target="_blank" href="https://twitter.com/ChrisBreuer1904"><i class="fa fa-twitter"></i></a></li>
                                    <li><a class="linkedin" target="_blank" href="https://www.linkedin.com/in/chris-breuer-33231765/"><i class="fa fa-linkedin"></i></a></li>
                                    <li><a class="facebook" target="_blank" href="https://www.facebook.com/chrisbreuer93"><i class="fa fa-facebook"></i></a></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <!-- END User widget -->

                    <!-- User widget -->
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="card user-widget">
                            <div class="card-block text-center">
                                <a href="https://clooud.tv/user/Bent"><img src="https://clooud.tv/uploads/avatars/bent.jpg" alt="Bent"></a>
                                <h5><a href="#">Bent Jenson Jr.</a></h5>
                                <p class="lead">Graphics</p>
                                <br>
                                <p class="text-justify">The reason this website is looking as it does is because of this guy!</p>
                            </div>

                            <div class="card-footer">
                                <ul class="social-icons">
                                    <li><a class="linkedin" target="_blank" href="https://www.linkedin.com/in/bent-jenson-457a5b87/"><i class="fa fa-linkedin"></i></a></li>
                                    <li><a class="facebook" target="_blank" href="https://www.facebook.com/bent.j.jenson"><i class="fa fa-facebook"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- END User widget -->

                    <!-- User widget -->
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="card user-widget">
                            <div class="card-block text-center">
                                <a href="https://clooud.tv/user/ahill41"><img src="https://clooud.tv/uploads/avatars/avery.jpg" alt="Avery"></a>
                                <h5><a href="#">Avery Hill</a></h5>
                                <p class="lead">Marketing</p>
                                <br>
                                <p class="text-justify">In charge of all the marketing related concerns and social media stuff!</p>
                            </div>

                            <div class="card-footer">
                                <ul class="social-icons">
                                    <li><a class="linkedin" target="_blank" href="https://www.linkedin.com/in/avery-hill-4599b4104/"><i class="fa fa-linkedin"></i></a></li>
                                    <li><a class="facebook" target="_blank" href="https://www.facebook.com/ave.hill"><i class="fa fa-facebook"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- END User widget -->

                </div>

            </div>
        </section>
        <!-- END Team -->
    </main>
    <!-- END Main container -->

@endsection