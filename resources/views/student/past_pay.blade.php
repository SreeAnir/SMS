@if( isset($fee_list))
<div class="card  border-0 ">
    <div class="card-body border-0">
        <h6 class="mb-1 text-muted">Fee & Payment History</h6>
        @foreach ($fee_list as $fee)
            <div id="payments_list">
                <div class="card">
                    <div class="card-header payment_details " role="button" id="pay1">
                        <div class="d-flex flex-row d-flex justify-content-between">
                            <label class="payment_details" role="button">

                                @include('common.status-badge', [
                                    'instance' => $fee,
                                ]) <span
                                    class="badge bg-dark mx-2">{{ feeTypelist()[$fee?->fee_type] }} </span>


                                Payment Amount <b> {{ priceFormatted($fee->amount) }}</b> | Discount Amount <b>
                                    {{ priceFormatted($fee->discount) }} </b>| Branch : {{ $fee->location?->name }}</b>

                            </label>


                            <label class="text-info bg-light text-underline view_btn" role="button"> View <svg
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-eye" viewBox="0 0 16 16">
                                    <path
                                        d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                    <path
                                        d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                </svg></label>
                        </div>
                    </div>

                    <div class="payment_summary" id="pay1details">
                        <div class="card-body">
                            <div class="flex-row d-flex justify-content-between">
                                <b>Summary</b>
                            <label role="button" class=" text-underline close_btn text-danger">X Close</label>
                            </div>
                            <div class="table-responsive">

                            <table class="table table-striped  shadow-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        @if ($fee->installment_nos > 1)
                                            <th scope="col" class="text-muted">Installments
                                            </th>
                                        @endif
                                        <th scope="col">Amount</th>
                                        <th scope="col">Due Date</th>
                                        <th scope="col">Paid Date</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fee->installments as $installment)
                                        <tr>
                                            <th scope="row">{{ $installment->current_installment }}</th>
                                            @if ($fee->installment_nos > 1)
                                            <td>{{ $installment->current_installment }}</td>
                                            @endif
                                            <td>{{ $installment->amount }}
                                                @include('common.status-badge', [
                                                    'instance' => $installment,
                                                ]) </td>
                                            <td>{{ $installment->payment_due_date }}</td>
                                            <td>{{ $installment->paid_date }}</td>
                                            @if ($fee->installment_nos > 1)
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endforeach

    </div>

</div>
@endif
