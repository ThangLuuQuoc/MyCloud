@extends('layouts.app', ['title' => 'News'])

@section('content')

    <!-- Main container -->
    <main>

        <section class="no-border-bottom section-sm">

            <header class="section-header">
                <span>Hello There</span>
                <h2>We got news.</h2>
                <p>Read below for what's happening.</p>
            </header>

            <div class="container">

                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="card" style="padding: 0px 25px">
                            <div class="card-header">
                                <h6>by chris</h6>
                            </div>
                            <div class="card-block">
                                <p>Great news! We just implemented many new features and improvements.</p>
                                <ul><li>unregistered users can now upload media</li>
                                    <li><strong>Remote Uploads!</strong></li>
                                    <li>Openload Uploads</li>
                                    <li>password protected files</li>
                                    <li>various other improvements</li>
                                </ul>
                                <p>That's the list of what has been implemented.</p>
                                <p> </p>
                                <p>What are "remote uploads"?</p>
                                <p>Let's say you have your files stored somewhere online already. Instead of uploading your file through our system, you can pass through your link (the URL where the file is stored) and we will automatically download the file for you and add it to your account. </p>
                                <p>We also now enabled Openload uploads. If you have files stored in Openload, just copy and paste those links under the "Openload" tab and these will be added to your account as well. Please note that during certain hours a day, Openload may experience high bandwith usage and not allow any API downloads. In that case, if you know how to access the direct URL to the file, you can still download it via the "Simple" remote upload.</p>
                                <hr>
                                <div>
                                    <span class="badge">Posted 2017-03-23 22:00 PST</span>
                                    <div class="pull-right">
                                        <span class="label label-success">News</span>
                                        <span class="label label-primary">Launch</span>
                                        <!--<span class="label label-default">blog</span>
                                        <span class="label label-info">personal</span>
                                        <span class="label label-warning">Warning</span>
                                        <span class="label label-danger">Danger</span>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="card" style="padding: 0px 25px">
                            <div class="card-header">
                                <h6>by chris</h6>
                            </div>
                            <div class="card-block">

                                <h1>Revolution has begun!</h1>
                                <p>We are proud and excited to launch Clooud.tv. After months of hard work we finally reached the point of where we would like to share our project with the public.</p>
                                <p>As daily users of media sharing sites ourselves, we got so annoyed by the abundance and ridiculous amount of advertisements that are visualized on many media sharing sites. We do understand that in order to run a successful business money has to be involved, but we found most commonly used advertising techniques absolutely horrible. Our idea is to provide a friendly, safe and innovative user experience which is not cluttered in ads. Hence, we understand the three priorities: Privacy, effectiveness, and no annoyance through advertising, such as popups. Those are our priorities and this is where we separate us drastically from any competition.</p>
                                <hr>
                                <div>
                                    <span class="badge">Posted 2017-03-14 16:00 PST</span>
                                    <div class="pull-right">
                                        <span class="label label-success">News</span>
                                        <span class="label label-primary">Launch</span>
                                        <!--<span class="label label-default">blog</span>
                                        <span class="label label-info">personal</span>
                                        <span class="label label-warning">Warning</span>
                                        <span class="label label-danger">Danger</span>-->
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