@extends('layouts.admin_master')

@section('content')
<!--header end here-->
<!--about start here-->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-header text-center">Posts</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          <a  role="button" class="btn btn-primary  btn_add">Add New Post</a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
        <table width="100%" class="table table-striped table-bordered table-hover" id="blog">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Title</th>
                                        <th>Short Desc</th>
                                        <th>Content</th>
                                        <th>Date</th>
                                        <th width="5%"></th>
                                        <th width="5%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($blogs))
                             @foreach ($blogs as $blog)
                    <tr>
                         <td>
                          {!! $blog->id !!}
                        </td>
                        <td>
                          {!! $blog->title !!}
                        </td>

                        <td>
                          {!! $blog->short_description !!}
                        </td>
                        <td>
                          {!! $blog->short_description !!}
                        </td>
                          <td>
                          {!! $blog->published_date !!}
                        </td>
                        
                        <td><a  role='button' data-edit-id='{!! $blog->id!!}' class='btn btn-primary editBtn' ><i class='fa fa-edit'></i></a></td>
                 <td><a href='#delete_modal' data-delete-id='{!! $blog->id!!}' class='btn btn-default deleteBtn' role='button' data-toggle='modal'><i class='fa fa-trash-o fa-lg text-danger'></i></a></td>
                    </tr>

                @endforeach
                         
                           @endif

                                </tbody>
                            </table>
                         
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>


            <!-- /.row -->
        </div>
<div class="modal fade" id="addUpdate_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"  id="addUpdate_modal_body">
     
    </div>
</div>


<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="delete_content">
            
        </div>
    </div>
</div>

@endsection
@section('script')
    <script type="text/javascript">
        $(function () {

              $('#blog').DataTable({
                            "paging": true,
                            "lengthChange": true,
                            "searching": true,
                            "ordering": true,
                             "responsive":true,
                            "info": true,
                            "autoWidth": true,
                            "order": [[0, "desc"]],
                            dom: 'Bfltip',
                            buttons: [
                                'copy', 'csv', 'excel', 'pdf', 'print'
                            ]
                        });


          $.ajaxSetup({ cache: false });
                        function bindForm(dialog) {
                            $("form", dialog).submit(function () {
                                $.ajax({
                                    url: this.action,
                                    type: this.method,
                                    data: new FormData(this),
                                    contentType: false,
                                    processData: false,
                                    success: function (result) {
                                        if (result.success) {
                                            $('#addUpdate_modal').modal("hide");
                                            // Refresh:
                                            location.reload();

                                        } else {

                                            $('#addUpdate_modal_body').html(result);
                                            bindForm();
                                        }
                                    }, error: function (request, status, error) {
                                        alert(error.Message);
                                    }
                                });


                                return false;
                            });
                        }


        //Load the edit page
        $(".editBtn").click(function () {

            $("#addUpdate_modal_body").load("/administrator/blog/" + $(this).data("edit-id")+"/edit",function(responseTxt, statusTxt, xh)
                {
                     $("#addUpdate_modal").modal({
                                    backdrop: 'static',
                                    keyboard: true
                                }, "show");
                                bindForm(this);
                });
            return false;
         });

    $(".btn_add").click(function () {
        $("#addUpdate_modal_body").load("/administrator/blog/create", function () {
            $("#addUpdate_modal").modal({
                backdrop: 'static',
                keyboard: true
                }, "show");
            bindForm(this);
                });
                return false;
         });

        //Handle the delete function
        $(".deleteBtn").click(function () {

            $("#delete_content").load("/administrator/blog/" + $(this).data("delete-id"));
        });


        });

        </script>


@stop