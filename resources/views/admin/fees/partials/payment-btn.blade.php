@php
    use Carbon\Carbon;
@endphp
@if ($pending_payment)

    <div class="p-3">
        @if ($no_installments == 1)
            <p class="alert alert-info">
                <b>**Payment Alert:**</b> <br />
                Recorded payment is pending for the student. Please update the payment details if already received.
            </p>
        @else
            <p class="alert alert-info">
                <b>**Payment Alert:**</b> <br /> Payment amount of {{ priceFormatted($next_payment?->amount) }} ,and due
                date is
                {{ Carbon::parse($next_payment?->payment_due_date)->format('d M Y') }}.Please update the payment
                details if already received.
            </p>
        @endif
        <div class="alert alert-warning d-flex flex-row justify-content-between">
            <label>Pending Amount : <b class="text-danger">{{ @priceFormatted($pending_amount) }} </b></label>
            @if ($pending_amount > 0 && @$add_pay_btn !=null)
                <input type="button" id="modelLoad" data-bs-toggle="modal" data-bs-target="#paymentModal"
                    class="btn btn-success text-white" value="New Payment Record">
            @endif
        </div>

    </div>
@endif
<!-- Modal payment-->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel"> {{ __('Fee Payment') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="user_payment">
                {{ __('Loading..') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="save_installment_btn" class="btn btn-primary">Save Payment</button>
            </div>
        </div>
    </div>
</div>
