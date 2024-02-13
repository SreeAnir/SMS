@if($completed)
<h2 class="heading" style="margin-top:5px;">Payment Summary</h2>
@else  
<h2 class="heading" style="margin-top:5px;">Partial Payments Summary</h2>
@endif
<table class="table table-striped">
    <thead class="text-start text-muted text-uppercase gs-0">
        <tr>
            <th>Installment No</th>
            <th>Payable Amount</th>
            <th>Due Date</th>
            <th>Paid Date</th>
            <th>Payment Status</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($installments as $key => $installment)
            <tr>
                <td><a role="button">{{ $installment->current_installment }}</a></td>
                <td>{{ $installment->amount }}</td>
                <td>{{ $installment->payment_due_date }}</td>
                <td>{{ $installment->paid_date }}</td>
                <td> @include('common.status-badge', ['instance' => $installment]) </td>
            </tr>
        @endforeach
    </tbody>
</table>

