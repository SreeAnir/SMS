@if ($installment->paid_date == null)
    @if ($installment->payment_due_date != '')
        @php
            $paymentDueDate = \Carbon\Carbon::parse($installment->payment_due_date);
        @endphp
        @if (\Carbon\Carbon::now()->diffInDays($paymentDueDate) <= 12  )
            <a data-attr="{{ Crypt::encrypt($installment->id )}}" role="button" class="btn btn-info pay_now" > Pay Now </a>
        @endif
    @endif
@else
    {{ @$installment->paid_date }}
@endif
  