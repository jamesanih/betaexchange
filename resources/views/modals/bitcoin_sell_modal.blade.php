@foreach($sell_bit as $data)
<div id="confirm_bit_sell" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">

      <form method="post" action="{{route('confirm_sell')}}" role="form" id="confirm_sell_bitcoin">
          {{csrf_field()}}
      <div class="modal-content">
        <div class="modal-header">
           <h4>confirm your payment</h4>
        </div>
        <div class="modal-body">
          
            
              <div class="form-group">
                   <label>Date Sent</label>
                  <input type="date" class="form-control" placeholder="Payment Date(d-m-y)" name="date_sent" id="date_sent">
              </div>



              <div class="form-group">
                   <label>Hash</label>
                  <input type="text" class="form-control" name="hash" id="hash" placeholder="">
              </div>

              <div class="form-group">
                  <label>Amount sent</label>
                  <input type="text" class="form-control" name="amount_sent" id="amount_sent" placeholder="Amount sent">
              </div>

              <div class="form-group">
                  <label>Wallet ID</label>
                <input type="text" class="form-control" name="wallet_id" id="wallet_id" placeholder="Enter your Wallet ID">
              </div>

              <input type="hidden" name="purchase_id" value="{{$data->id}}">
            
          
          
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <input type="submit" name="confirm_btn" value="OK" class="btn btn-primary">
        </div>


      </div>
    </form>
    </div>
</div>


<div id="delete_bit_modal" class="modal fade" tabindex="-1" role="dialog" aria-labellby="myModalLabel" aria-hidden="true">
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
          <a href="{{route('delete_bitcoin_sell', ['id'=>$data->id])}}" class="btn btn-xm btn-primary waves-effect">Ok</a>
        </div>

             
    </div>
  </div>
</div>

@endforeach

