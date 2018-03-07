@extends('layouts.app', ['title' => 'TOS'])

@section('content')

    <!-- Main container -->
    <main>

        <!-- TOS -->
        <section class="bg-white">
            <div class="container">
                <header class="section-header">
                    <span>Rules</span>
                    <h2>Terms Of Service</h2>
                    <p>Keep reading this section to figure which rules to go by.</p>
                </header>

                <h5>Terms & Conditions</h5>
                <p>{{ ucfirst(request()->getHost()) }} reserves the right to remove any files that compromise the security of the server, use excess bandwidth, or are otherwise malignant.
                    The following types of files may not be uploaded under any circumstances:
                    <ul class="intext">
                        <li>Files that infringe on the copyrights of any entity.</li>
                        <li>Files that are illegal and/or are in violation of any laws.</li>
                    </ul>
                </p>
                <h5 class="other-title">Terms Of Usage</h5>
                <p>{{ ucfirst(request()->getHost()) }} assumes no liability for lost or corrupt links, files or misplaced file URLs. It is user's responsibility to keep track of this information.</p>
                <h5 class="other-title">Legal Policy</h5>
                <p>These Terms of Service are subject to change without prior warning. By using {{ ucfirst(request()->getHost()) }}, user agrees not to involve {{ ucfirst(request()->getHost()) }} in any type of legal action.<br>
                    {{ ucfirst(request()->getHost()) }} directs full legal responsibility of the contents of the files that are uploaded to {{ ucfirst(request()->getHost()) }} to individual users, and will cooperate with copyright owners and law enforcement entities in the case that uploaded files are deemed to be in violation of these Terms of Service.<br><br>
                    All files are copyrighted to their respective owners. {{ ucfirst(request()->getHost()) }} is not responsible for the content of any uploaded files, nor is it in affiliation with any entities that may be represented in the uploaded files.</p>
            </div>
        </section>
        <!-- END TOS -->

    </main>
    <!-- END Main container -->

@endsection