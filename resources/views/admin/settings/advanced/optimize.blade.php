@extends('admin.settings.layouts.advanced')

@section('styles')
    <style>
        .btn {
            margin: 5px;
        }
    </style>
@endsection

@section('settings-content')
    <section class="content-header" style="margin-bottom: 25px">
        <h1>
            Optimizing Files
            <small>Easy way to clear cache, views, sessions and optimize</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-Teal">
                    <div class="box-header with-border">
                        <h3 class="box-title">Clear Files</h3>
                    </div><!-- /.box-header -->

                    @if (session()->has('flash_notification.message'))
                        <div class="alert alert-{{ session('flash_notification.level') }}">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                            </button>
                            {!! session('flash_notification.message') !!}
                        </div>
                    @endif
                    @if ( $errors->any() )
                        <div class="col-md-12" style="margin-top:15px;">
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×
                                </button>
                                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                <ul>
                                    @foreach ( $errors->all() as $error )
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    {{ method_field('patch') }}
                    <div class="box-body">

                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <label for="max_tags_per_media">
                                        <i style="font-size:16px;" class="fa fa-list"></i> Clear Files
                                    </label>
                                </div>

                                <div class="panel-body">
                                    <div class="form-group">
                                        <a class="btn btn-sm btn-warning" data-button-type="delete" href="{{ route('advanced.optimize.update', ['cache']) }}"><i class="fa fa-trash-o"></i> Clear Cache</a>
                                        <a class="btn btn-sm btn-warning" data-button-type="delete" href="{{ route('advanced.optimize.update', ['view']) }}"><i class="fa fa-trash-o"></i> Clear Views</a>
                                        <a class="btn btn-sm btn-warning" data-button-type="delete" href="{{ route('advanced.optimize.update', ['session']) }}"><i class="fa fa-trash-o"></i> Clear Sessions</a>
                                        <a class="btn btn-sm btn-warning" data-button-type="delete" href="{{ route('advanced.optimize.update', ['clear-routes']) }}"><i class="fa fa-trash-o"></i> Clear Route's Cache</a>
                                        <a class="btn btn-sm btn-warning" data-button-type="delete" href="{{ route('advanced.optimize.update', ['clear-config']) }}"><i class="fa fa-trash-o"></i> Clear Config Cache</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <label for="max_tags_per_media">
                                        <i style="font-size:16px;" class="fa fa-list"></i> Optimize Files
                                    </label>
                                </div>

                                <div class="panel-body">
                                    <div class="form-group">
                                        <a class="btn btn-sm btn-primary" data-button-type="update" href="{{ route('advanced.optimize.update', ['optimize']) }}"><i class="fa fa-wrench"></i> Optimize Class Loader</a>
                                        <a class="btn btn-sm btn-primary" data-button-type="update" href="{{ route('advanced.optimize.update', ['cache-routes']) }}"><i class="fa fa-wrench"></i> Cache Routes</a>
                                        <a class="btn btn-sm btn-primary" data-button-type="update" href="{{ route('advanced.optimize.update', ['cache-config']) }}"><i class="fa fa-wrench"></i> Cache Config Files</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- /.box-body -->

                    <hr>

                </div><!-- /.box -->
            </div><!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">
                <!-- Horizontal Form -->
            </div>
        </div><!-- /.row -->
    </section><!-- /.content -->

@endsection

@section('scripts')
    <script>
        PNotify.prototype.options.styling = "bootstrap3";
        PNotify.prototype.options.styling = "fontawesome";

        // capture the delete button
        $("[data-button-type=delete]").click(function(e) {
            e.preventDefault();
            var delete_url = $(this).attr('href');

            swal({
                title: "Are you sure you want to delete these files?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes!",
                closeOnConfirm: true
            }, function () {

                var data = {
                    _token: "{{ csrf_token() }}",
                };

                $.ajax({
                    url: delete_url,
                    type: "POST",
                    data: data,
                    success: function (data) {
                        new PNotify({
                            title: "Done",
                            text: "These files were deleted.",
                            type: "success"
                        });
                    }, error: function () {
                        new PNotify({
                            title: "Error",
                            text: "These files were not deleted.",
                            type: "warning"
                        });
                    }
                }); //end of ajax

            });
        });

        // capture the delete button
        $("[data-button-type=update]").click(function(e) {
            e.preventDefault();
            var update_url = $(this).attr('href');

            swal({
                title: "Are you sure you want to update these files?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes!",
                closeOnConfirm: true
            }, function () {

                var data = {
                    _token: "{{ csrf_token() }}",
                };

                $.ajax({
                    url: update_url,
                    type: "POST",
                    data: data,
                    success: function (data) {
                        new PNotify({
                            title: "Done",
                            text: "These files were updated.",
                            type: 'error'
                        });
                    }, error: function () {
                        new PNotify({
                            title: "Error",
                            text: "These files were not updated.",
                            type: "warning"
                        });
                    }
                }); //end of ajax

            });
        });
    </script>
@endsection
