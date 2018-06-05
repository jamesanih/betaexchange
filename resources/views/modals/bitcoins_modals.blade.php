<div id="confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">

      <form method="post" action="{{route('confirm_bitcoin')}}" role="form" enctype="multipart/form-data" id="confirm_buy_bitcoin">
          {{csrf_field()}}
      <div class="modal-content">
        <div class="modal-header">
           <h4>confirm your payment</h4>
        </div>
        <div class="modal-body">
          
            
              <div class="form-group">
                   <label>Date Sent</label>
                  <input type="date" class="form-control" placeholder="Payment Date(d-m-y)" name="date" id="date">
              </div>



              <div class="form-group">
                   <label>Transfer Details</label>
                  <input type="text" class="form-control" name="details_no" id="details_no" placeholder="eg:memo/teller_no/transfer-ref_no">
              </div>

              <div class="form-group">
                  <label>Amount Paid</label>
                  <input type="text" class="form-control" name="amount_paid" id="amount_paid" placeholder="Amount paid">
              </div>

              <div class="form-group">
                  <label>Depositor Name</label>
                <input type="text" class="form-control" name="depositor_name" id="depositor_name" placeholder="eg:john eze">
              </div>

            
          
          <div class="form-group">
            <label>Upload Receipt(2mb JPG,PNG,PDF format only)</label>
            <input type="file" name="receipt_dir">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <input type="submit" name="confirm_btn" value="OK" class="btn btn-primary">
        </div>


      </div>
    </form>
    </div>
</div>

@foreach($modal_user as $data)
<div id="delete_modal" class="modal fade" tabindex="-1" role="dialog" aria-labellby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4>Delete Order</h4>
      </div>
        <div class="modal-body">
         
          Do You Really want canel this order
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-xm btn-danger waves-effect" data-dismiss="modal">Close</button>
          <a href="{{route('delete_order', ['id'=>$data->id])}}" class="btn btn-xm btn-primary waves-effect">Ok</a>
        </div>

             
    </div>
  </div>
</div>

@endforeach

