 <div class="card">
     <div class="card-body text-secondary">
         @php
             use Illuminate\Support\Facades\Crypt;
         @endphp
         <!-- Payment details display -->
         <div class="border border-light p-2 mb-2"><strong>Student Fee:</strong> {{ $fee->amount }} 
             @if ($fee->installment_nos > 1 )
                , Installment No - {{ @$fee->newpayment->current_installment }}
             @endif
         </div>

         <!-- Form for receipt details and payment mode -->
         <form id="save_installment">

             <hr />
             <div class="row text-dark">
                 <div class="col-6">
                     <div class="form-group">
                         <label for="paymentMode">Payment Mode<span class="text-danger">*</span></label>
                         <select class="form-control" id="paymentMode">
                             @foreach (paymentModeList() as $type => $key)
                                 <option value="{{ $type }}">{{ $key }}</option>
                             @endforeach
                         </select>
                     </div>
                 </div>

                 <div class="col-6">
                     <div class="form-group">
                         <label for="paymentMode">Payment Date<span class="text-danger">*</span></label>
                         <input class="form-control" id="paid_date" name="paid_date" placeholder="yyyy-mm-dd">
                     </div>
                 </div>
                 <div class="col-12">
                     <div class="form-group">
                         <label for="paymentMode">Transaction Info</label>
                         <input class="form-control" id="transaction_info" name="transaction_info">
                     </div>
                 </div>
                 <div class="col-12">
                     <div class="form-group">
                         <label for="paymentMode">Payment Note</label>
                         <input class="form-control" id="remarks" name="remarks">
                         <input type="hidden" value="{{ Crypt::encrypt(@$fee->newpayment->id) }}" name="fee_log_id">
                     </div>
                 </div>
             </div>
         </form>
         <div class="bg-light px-2 py-1">
             <p for="receiptNumber">Installment Amount :
                 <span class="text-success"> {{ priceFormatted(@$fee->newpayment->amount) }}
                 </span>
             </p>
             <p for="receiptNumber">Installment due date :
                 <span class="text-info"> {{ @$fee->newpayment->payment_due_date }}
                 </span>
                 <label class="pt-1 d-block">( {{ $fee->newpayment->due_date }})</label>
             </p>
         </div>
     </div>
 </div>
