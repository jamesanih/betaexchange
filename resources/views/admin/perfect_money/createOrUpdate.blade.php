
<div class="modal-content">
@if(isset($perfect))
     {!! Form::model($perfect, array('route' => array('perfect-money.update', $perfect->id), 'method' => 'PUT')) !!}
@else
    {!! Form::open(array('url' => '/administrator/perfect-money')) !!}
@endif

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">{!! $page_title !!} Order</h4>
        </div>
        <div class="modal-body">
          <div class="tabs-framed">
           <ul class="tabs clearfix">

  <li style="padding: 5px;" class="active"><a data-toggle="tab" href="#home">Basic Details</a></li>
  <li style="padding: 5px;"><a data-toggle="tab" href="#menu2">Order Details</a></li>
 
</ul>
<div class="tab-content">
  <div id="home" class="tab-pane fade in active">

             <div class="form-group">
                <label for="first_name">First Name:</label>
            <input type="text" name="first_name" value="{{ $user->first_name}}" class="form-control input-lg" readonly="true" >
                  </div>      
                 <div class="form-group">
                    <label for="middle_name">Middle Name:</label>
            <input type="text" name="middle_name" value="{{ $user->middle_name}}" class="form-control input-lg" readonly="true" >
                </div>
             <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" value="{{ $user->last_name}}" class="form-control input-lg" readonly="true" >
                           

             </div>


        <div class="form-group">
            <label for="email">Email Address:</label>
           
 <input type="email" name="email" value="{{ $user->email}}" class="form-control input-lg" readonly="true" >
             

        </div>
        <div class="form-group">
            <label for="phone_no">Phone No:</label>
            <input type="text" name="phone_no" value="{{ $user->phone_no}}" class="form-control input-lg" readonly="true">
                  </div> 
         <div class="form-group" style="margin-top: 25px;"> 
          <label for="activation_status"></label>
        {!! Form::select('activation_status',$status, Input::old('activation_status'),['class' => ' btn btn-default btn-lg',
         'required' => "true",'tabindex'=>"5"]) !!}
         </div>
  </div>

  <div id="menu2" class="tab-pane fade">

                    <div class="form-group">
                <label for="nfirst_name">Units:</label>
                   <input type="text" name="nfirst_name" value="{{ $perfect->unit}}" class="form-control input-lg" readonly="true">
                  </div>      
                 <div class="form-group">
                    <label for="nmiddle_name">Total:</label>
    <input type="text" name="nmiddle_name" value="{{ $perfect->total}}" class="form-control input-lg" readonly="true">
                  </div>  

               
             <div class="form-group">
            <label for="nlast_name">Account Name:</label>
            <input type="text" name="nlast_name" value="{{ $perfect->account_name}}" class="form-control input-lg" readonly="true">
                  </div>
          <div class="form-group">
            <label for="nlast_name2">Account No:</label>
            <input type="text" name="nlast_name2" value="{{ $perfect->account_no}}" class="form-control input-lg" readonly="true">
                  </div>
                   <div class="form-group">
                    <label for="bank_name">Payment Method:</label>
    <input type="text" name="bank_name" value="@if ($perfect->method==1)
                             {!! "Internet Bank Transfer"  !!}
                         @endif
                        @if ($perfect->method==2)
                             {!! "Bank Deposit"  !!}
                         @endif
                          @if ($perfect->method==3)
                             {!! "Short Code"  !!}
                         @endif" class="form-control input-lg" readonly="true">
                  </div>  
                   <div class="form-group">
                    <label for="account_no">Ref No:</label>
    <input type="text" name="account_no" value="{{ $perfect->ref_no}}" class="form-control input-lg" readonly="true">
                  </div> 
                   <div class="form-group">
                    <label for="status">Process Payment:</label>
       {!! Form::checkbox('status',$perfect->status,null,['class'=>"form-control input-lg"]) !!}
  
                  </div>     
  </div>
</div>
</div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">{!! $page_action !!}</button>

        </div>
   {!! Form::close() !!}
</div>
