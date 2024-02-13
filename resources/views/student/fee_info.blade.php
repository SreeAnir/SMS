 <div class="row ">
     @if (@$new_payment == null)
     <div class=" col-sm-12">
        <div class="  m-1 p-md-3">
            <h6 class="mb-1 text-secondary text-center">No Active Payments!</h6>
        </div>
     </div>
     @else 
         <!-- Event 1 -->
         <div class=" col-sm-12">
             <div class="  m-1 p-md-3">
                 <h6 class="mb-1 text-secondary text-center">Active Payment</h6>

                 <div class="list-group-item  ">
                     <div class="mr-auto text-secondary">

                         <ul class="list-group border-0 bg-light w-100">
                             <li class="list-group-item d-flex flex-column  flex-lg-row justify-content-between ">
                                 <div class="d-flex flex-row">
                                    <p>
                                     Payment Amount
                                     <span class="badge bg-info mx-2">
                                         {{ priceFormatted($new_payment?->amount) }} </span>
                                     </p> 
                                     <p>
                                     <span class="badge bg-dark mx-2">
                                         {{ feeTypelist()[$new_payment?->fee_type] }} </span>
                                         @if ($new_payment->installment_nos > 1)
                                         <span class="badge bg-warning mx-2">
                                            {{ $new_payment?->installment_nos }} installments </span>
                                         @endif
                                     </p>
                                 </div>
                             </li>
                            
                             <li class="list-group-item">
                                 <p class="mb-1">
                                    <label>Pending Amount :   {{ $new_payment->unpaidAmount() }} , 
                                     Discount Amount : {{ $new_payment->discount }} </label>
                                  </p>
                             </li>
                             
                         </ul>

                     </div>
                 </div>
             </div>
         </div>
         <div class=" col-sm-12">
             @if ($new_payment != null)
                 <div class=" 1shadow-sm  m-1 p-md-3">
                     {{-- <h6 class="mb-1 text-secondary text-center">Upcoming payments</h6> --}}

                     <div class="list-group-item">
                         <div class="mr-auto text-secondary">

                             <table class="table table-responsive" style="border: 1px solid #eee;">
                                 <thead>
                                     <tr>
                                         <th scope="col" class="text-muted">Amount</th>
                                         @if ($new_payment->installment_nos > 1)
                                             <th scope="col" class="text-muted">Installment
                                             </th>
                                         @endif
                                         <th scope="col" class="text-muted">Due Date</th>
                                         <th scope="col" class="text-muted">Paid Date</th>

                                     </tr>
                                 </thead>
                                 <tbody>
                                     @foreach ($new_payment->installments as $installment)
                                         <tr>
                                             <td>{{ $installment->amount }}
                                                 @include('common.status-badge', [
                                                     'instance' => $installment,
                                                 ]) </td>
                                             @if ($new_payment->installment_nos > 1)
                                                 <td>{{ $installment->current_installment }}</td>
                                             @endif
                                             <td>{{ $installment->payment_due_date }}</td>
                                             <td>
                                                @include('student.includes.payment-button', [
                                                    'instance' => $installment,
                                                ]) 
                                                 </td>
                                             {{-- payment_due_date --}}
                                         </tr>
                                     @endforeach

                                 </tbody>
                             </table>

                         </div>
                     </div>
                 </div>
             @endif
         </div>
         <hr />

     @endif
 </div>

 
@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    let payment_url = "";
    function processPay(){
        if(payment_url!=""){
                 $.ajax({
                    url: payment_url ,
                    type: 'GET',
                    dataType: "json", // specify that you expect JSON in the response
                    beforeSend: function () {
                        console.log("Py Create");
                    }
                })
                .done(function (data) {
                   console.log("Py Done",data);
                    if (data.status == "success") {
                        if( data.redirect_route !=null){
                            window.location= data.redirect_route;
                            // window.location= data.redirect_route;
                        }else{
                        swalError("Error", "Not Available");
                        location.reload();
                        }
                    }else{
                        swalError( data.message_title, data.message);
                    }
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                        swalError("Error", jqXHR.responseJSON.message);
                    } else {
                        swalError("Error", "Failed to proceed");
                    }
                });
        }

    }
    $(document).ready(function(){
        
            $(document).on('click', '.pay_now', function(e) {
                let id = $(this).data('attr');
                payment_url ="";
                let route = "{{ route('checkpay.log',['']) }}";
                $.ajax({
                    url: route +'/'+id ,
                    type: 'GET',
                    beforeSend: function () {
                        swalLoader("Please wait while we check the payment details." );
                        console.log("Loading Payment check");
                    }
                })
                .done(function (data) {
                   console.log("Loading done");
                    if (data.status == "success") {
                        if( data.redirect_route !=null){
                            swalConfirm(data.confirmation_message )
                            .then((result) => {
                            if (result.isConfirmed) {
                                payment_url = data.redirect_route;
                                swalLoader();
                                processPay();
                                // this.run();
                            }
                            });
                            // window.location= data.redirect_route;
                        }
                        
                    }else{
                         
                    }
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                        swalError("Error", jqXHR.responseJSON.message);
                    } else {
                        swalError("Error", "Failed to proceed");
                    }
                });
            });
        });
 </script>           
 @endpush