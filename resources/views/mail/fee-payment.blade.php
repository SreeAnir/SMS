@extends('mail.general_layout')
@php
    use App\Models\Status;
    $fee = $fee_log->fee;
    $user = $fee->user;
    $batch = $fee->user->student->batch;
    $installments = $fee->installments;
    $pending_amount = $fee->amount - $fee->discount;
    $completed = $fee->status_id == Status::STATUS_PAID ? true : false;
    $payment_installment = "student fee" ;
    if($fee->installment_nos >  1){
    $payment_installment = ordinal( $fee_log->current_installment).' installment';
    }
    $unpaidAmount = $fee->unpaidAmount();

    if ($batch->count() > 0) {
        $subject = 'Payment Receipt and Acknowledgment - Training Program Batch ' . @$batch[0]->batch_name . ', Location ' . @$batch[0]->location->name;
    } else {
        $subject = 'Payment Receipt and Acknowledgment - Training Program Batch';
    }

@endphp
@section('email_subject')

@section('email_content')
    <p>Dear {{ $user->full_name }},</p>
    <p>We trust this message finds you in good health and high spirits.
        We would like to extend our gratitude for your prompt payment of the {{ $payment_installment }} towards your
        training program associated.</p>
    <p>Your commitment to staying on schedule with your payments is greatly appreciated.
        To confirm the successful processing of your payment, we are pleased to provide you with the details of the
        transaction:
    </p>
  
    <p>
        Thank you for choosing {{ env('APP_NAME') }}. We look forward to continuing to support you in your pursuit of
        learning & skills.
    </p>
    @if ($fee->installment_nos >  1)
        <table class="table table-striped">
            <thead class="text-start text-muted text-uppercase gs-0">
                <tr>
                    <th>Installment No</th>
                    <th>Installment Amount</th>
                    <th>Date</th>
                    <th>Pending Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><a role="button">{{ ordinal($fee_log->current_installment) }}</a></td>
                    <td>{{ $fee_log->amount }}</td>
                    <td>{{ $fee_log->paid_date }}</td>
                    <td>{{ priceFormatted(@$fee_log->unpaidAmount()) }}</td>

                </tr>
            </tbody>
        </table>
        @include('admin.fees.partials.mail-installments')
    @else
    <table class="table table-striped">
        <thead class="text-start text-muted text-uppercase gs-0">
            <tr>
                <th>Payment Amount</th>
                <th>Discount</th>
                <th>Final Amount</th>
                <th>Paid Date</th>

            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ priceFormatted($fee_log->amount) }}</td>
                <td>{{ priceFormatted($fee_log->discount) }}</td>
                <td>{{ priceFormatted( $fee_log->amount  - $fee_log->discount )}}</td>
                <td>{{ $fee_log->paid_date }}</td>
            </tr>
        </tbody>
    </table>
    @endif
    <p>
        If you have any questions or concerns regarding your payment or if you require any additional documentation, please
        feel free to reach out to us. We are here to assist you and provide any necessary support.
    </p>

    <p>Best regards,</p>
    <p>Team {{ env('APP_NAME') }} </p>
@endsection
