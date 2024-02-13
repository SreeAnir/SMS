@extends('mail.general_layout')
@php
    use App\Models\Status;
    use Carbon\Carbon;
    $fee = $installment->fee;
    $user = $fee->user;
    $batch = $fee->user->student->batch;
    $installments = $fee->installments;
    $pending_amount = $fee->amount - $fee->discount;
    $completed = $fee->status_id == Status::STATUS_PAID ? true : false;
    $payment_installment = 'student fee';
    if ($fee->installment_nos > 1) {
        $payment_installment = ordinal($installment->current_installment) . ' installment';
    }
    $unpaidAmount = $fee->unpaidAmount();
@endphp
@section('email_subject')
    {{ $subject }}
@endsection

@section('email_content')
    <p>Dear {{ $user->full_name }},</p>
    <p> I hope this email finds you well.
        We appreciate your commitment to your training program with us. </p>

    <p>

        @if (Carbon::today() == $installment->payment_due_date)
            I just wanted to quickly remind you that the payment due today.
        @else
            This is a friendly reminder and update regarding the installment payments for your training,
            associated with Batch {{ @$batch[0]->batch_name }} at our {{ @$batch[0]->location->name }}.The payment due date is {{  $installment->payment_due_date }}.
        @endif

    </p>
    <p> <u>Here is a summary of your upcoming payment schedule:</u></p>

    @if ($fee->installment_nos > 1)
        <table class="table table-striped">
            <thead class="text-start text-muted text-uppercase gs-0">
                <tr>
                    <th>Installment No</th>
                    <th>Installment Amount</th>
                    <th>Pending Amount</th>
                    <th>Due date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><a role="button">{{ ordinal( $installment->current_installment ) }}</a></td>
                    <td>{{ priceFormatted($installment->amount) }}</td>
                    <td>{{ priceFormatted(@$unpaidAmount) }}</td>
                    <td>{{ $installment->payment_due_date }}</td>
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

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ priceFormatted($installment->amount) }}</td>
                    <td>{{ priceFormatted($installment->discount) }}</td>
                    <td>{{ priceFormatted($installment->amount - $installment->discount) }}</td>
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
