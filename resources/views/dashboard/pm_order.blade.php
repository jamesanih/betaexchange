@extends('layouts.user_master')

@section('content')
<div class="container">
	<div id="page-wapper">
		<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Perfect Money</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

            <div class="row">
            	<div class="col-md-12">
            		<div class="tabs-framed">
            			<ul class="tabs clearfix">

  							<li style="padding: 5px;" class="active"><a data-toggle="tab" href="#home">Perfect Money Ordered</a></li>
						    <li style="padding: 5px;"><a data-toggle="tab" href="#menu2">Perfect Money Sold </a></li>
 
						</ul>


						<div class="tab-content">
							<div id="home" class="tab-pane fade in active">
								<div class="panel panel-default">
									<div class="panel-heading">
			                           Perfect Money ordered
			                        </div>
			                        @if (Session::has('message'))
			                         <div class="alert alert-info text-center" role="alert">
			                             <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

			                        {{ Session::get('message') }}
			                        </div>
			                        @endif
			                        <div class="panel-body">
			                        <table width="100%" class="table table-striped table-bordered table-hover" id="ordered_pm">
			                        	<thead>
			                        		<tr>
			                        			<th>Date</th>
			                        			<th>Ref No</th>
			                        			<th>Account Name</th>
			                        			<th>Account No</th>
			                        			<th>Units</th>
			                        			<th>Total</th>
			                        			<th>Payment Method</th>
		                                        <th>Status</th>
                                        		<th width="5%" id="head_display">Details</th>
                                         		<th width="5%" id="deletebtn"></th>
			                        		</tr>
			                        	</thead>
			                        	<tbody>
			                        		@if(count($pm))
			                        			@foreach($pm as $pm_order)

			                        				<tr>
			                        					<td>{!! $pm_order->created_at->todatestring() !!}</td>
			                        					<td>{!! $pm_order->ref_no !!}</td>
			                        					<td>{!! $pm_order->account_name !!}</td>
			                        					<td>{!! $pm_order->account_no !!}</td>
			                        					<td>{!! $pm_order->unit !!}</td>
			                        					<td>{!! $pm_order->total !!}</td>
		                        						@if($pm_order->method == 1)
		                        							<td>Internet Bank Transfer</td>
		                        						@elseif($pm_order->method == 2)
		                        							<td>Bank Deposit</td>
		                        						@elseif($pm_order->method == 3)
		                        							<td>Short Code</td>
		                        						@endif

		                        						@if($pm_order->status == 0)
		                        							<td>Processing</td>
		                        							<td><a href="#confirm" id="confirm_payment"  role='button' data-edit-id='{!! $pm_order->id!!}' class='btn btn-default editBtn' data-toggle="modal"><i class='fa fa-edit'></i>confirm payment</a></td>
									                        <td><a href='#delete_modal' data-delete-id='{!! $pm_order->id!!}' class='btn btn-danger deleteBtn' role='button' data-toggle='modal'><i class='fa fa-trash-o fa-lg'></i></a></td>
		                        						@else
		                        							<td>Completed</td>
		                        							 <td><a id="#details"  role='button' data-edit-id='{!! $pm_order->id!!}' class='btn btn-default editBtn' ><i class='fa fa-edit'></i>Details</a></td>
		                        						@endif
			                        					
			                        				</tr>

			                        			@endforeach

			                        		@endif
			                        	</tbody>
			                        </table>
			                        </div>
									<!-- /.panel-body -->
								</div>
								
							</div>


							<!-- second tab -->

							<div class="tab-pane fade" id="menu2">
								<div class="panel panel-default">
									<div class="panel-heading">
										 Perfect money sold
									</div>

									<div class="panel-body">
										 <table width="100%" class="table table-striped table-bordered table-hover" id="sold_pm">
			                        	<thead>
			                        		<tr>
			                        			<th>Date</th>
			                        			<th>Ref No</th>
			                        			<th>Account Name</th>
			                        			<th>Account No</th>
			                        			<th>Bank Name</th>
			                        			<th>Email</th>
			                        			<th>Phone No</th>
			                        			<th>Price</th>
			                        			<th>Units</th>
			                        			<th>Total</th>
			                        			<th width="5%">confirm sale</th>
                                         		<th width="5%"></th>
			                        			
			                        		</tr>
			                        	</thead>
			                        	<tbody>
			                        		@if(count($pm_sold))
			                        			@foreach($pm_sold as $pm)
			                        			<tr>
			                        				<td>{!! $pm->created_at !!}</td>
			                        				<td>{!!$pm->ref_no !!}</td>
			                        				<td>{!! $pm->account_name !!}</td>
			                        				<td>{!! $pm->account_no !!}</td>
			                        				<td>{!! $pm->bank_name !!}</td>
			                        				<td>{!! $pm->email !!}</td>
			                        				<td>{!! $pm->phone_no !!}</td>
			                        				<td>{!! $pm->price !!}</td>
			                        				<td>{!! $pm->unit !!}</td>
			                        				<td>{!! $pm->total !!}</td>
			                        				 <td><a href="#confirm_pm_sell" id="confirm_payment"  role='button' class='btn btn-default editBtn' data-toggle="modal"><i class='fa fa-edit'></i>confirm sales</a></td>
							                        <td><a href='#delete_pm_modal' class='btn btn-danger deleteBtn' role='button' data-toggle='modal'><i class='fa fa-trash-o fa-lg'></i></a></td>
			                        			</tr>
			                        			@endforeach
			                        		@endif
			                        	</tbody>
			                        </table>
									</div>
								</div>
							</div>

							
							<!-- end of second tab -->
						</div>
						<!-- end of tab content -->

            		</div>
            		<!-- end of tabs frames -->
            	</div>
            	<!-- col -->
            </div>
            <!-- row -->
	</div>


	 @include('modals.pm_modals')
	  @include('modals.pm_sell_modal')
</div>


@endsection
@section('script')
    <script type="text/javascript">
        $(function () {

          if($('#details').length) {
            $('#head_display').html("Details");
            $('#deletebtn').hide();
          }


           if($('#confirm_payment').length) {
            $('#head_display').html("Confirm Payment");
          }

              $('#ordered_pm').DataTable({
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


                $('#sold_pm').DataTable({
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



        });

        </script>
@stop