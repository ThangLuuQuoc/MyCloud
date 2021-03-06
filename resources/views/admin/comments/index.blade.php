@extends('admin.index')
@section('style')
    {!! Html::style('assets/admin/assets/plugins/datatables/dataTables.bootstrap.css') !!}
    {!! Html::style('assets/admin/assets/plugins/select2/select2.min.css') !!}
    {!! Html::style('assets/admin/assets/plugins/sweet-alert/sweetalert.css') !!}
@endsection
@section('page-content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Comments
                <small>All Comments</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">All Comments Table</h3>
                        </div>
                        <div class="box-body">

                            <table class="table table-borderd table-bordered table-striped dataTable">
                                <thead>
                                <tr>
                                    <th><i class="fa fa-key"></i></th>
                                    <th><i class="fa fa-user"></i></th>
                                    <th><i class="fa fa-comment"></i></th>
                                    <th><i class="fa fa-paper-plane"></i></th>
                                    <th><i class="fa fa-calendar"></i></th>
                                    <th><i class="fa fa-cog"></i></th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>comment</th>
                                    <th>Media</th>
                                    <th>Created at</th>
                                    <th>Options</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /.content -->
    </div>
@endsection
@section('javascript')
    {!! Html::script('assets/admin/assets/plugins/datatables/jquery.dataTables.min.js') !!}
    {!! Html::script('assets/admin/assets/plugins/datatables/dataTables.bootstrap.min.js') !!}
    {!! Html::script('assets/admin/assets/plugins/select2/select2.full.min.js') !!}
    {!! Html::script('assets/admin/assets/plugins/sweet-alert/sweetalert.min.js') !!}
    <script>
        $(document).ready(function () {
            // Init Select 2
            $('#status').select2();
            $('#type').select2();

            // Table Filters
            var route = '{{ route('comments.index') }}';

            var table = $('.table').DataTable({
                url: route,
                processing: true,
                serverSide: true,
                aaSorting: [[0, 'desc']],
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'username', name: 'username', orderable: false, searchable: false},
                    {data: 'body', name: 'body', orderable: true, searchable: true},
                    {data: 'media', name: 'media', orderable: false, searchable: false},
                    {data: 'created_at', name: 'created_at', orderable: true},
                    {data: 'options', name: 'options', orderable: false, searchable: false},
                ],

                ajax: route
            });

            // Ajax Delete Comment
            $('.table tbody').on('click', 'td button[type=button]', function (event) {
                event.preventDefault();
                var $row = jQuery(this).closest("tr");
                var id = $row.find("button[type=button]").data("id");
                swal({
                    title: "Are you sure To Delete <span style='color:#DD6B55'> " + name + " </span>?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                    html: true
                }, function () {

                    var data = {
                        _token: "{{ csrf_token() }}",
                    }

                    var path = "{{ route('comments.destroy',0) }}";

                    var url = path.replace(0, id);

                    $.ajax({
                        url: url,
                        type: "DELETE",
                        data: data,
                        success: function (data) {
                            swal("Deleted!", "The Comment has been deleted.", "success", true);
                            table.ajax.reload();
                        }, error: function () {
                            swal("Error", "System Can't Delete This Category! :)", "error");
                        }
                    }); //end of ajax

                });
            });
        });
    </script>
@endsection
