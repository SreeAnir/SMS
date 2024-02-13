@php
    $pending_payment = 0;
    $no_installments = @$user->fee->installment_nos;
    $next_payment = null;
    $pending_amount = @$user->fee->amount;
@endphp
<div class="card mb-xxl-8 box-card ">
    <div id="installment_details" class="card-body pt-9 pb-0">
        @if (@$user->fee->installment_nos == 1)
            <div class="d-flex flex-column flex-sm-row justify-content-between">
                <h6 class="text-muted"> Fees Details
                </h6>
            </div>
            <div class="d-flex flex-column flex-sm-row justify-content-between p-3">
                @foreach ($user->fee->installments as $key => $installment)
                    @php
                        if (!$installment->isPaid()) {
                            $pending_payment = 1;
                        } else {
                            $pending_amount = 0;
                        }
                    @endphp
                    <label>Amount : {{ $installment->amount }} AED
                        @include('common.status-badge', ['instance' => $installment])
                    </label>
                @endforeach
            </div>
        @else
            @if (@$user->fee == null)
                <h6 class="text-muted">Add the fees information for the user</h6>
            @else
                <h6 class="text-muted">Installments
                    @include('admin.fees.partials.payment-btn', ['fee' => $user->fee])
                    {{-- <a tole="button" id="notify_user"  class="btn btn-success text-white float-right" ><b>Notify Student</b> --}}
                    {{-- </a> --}}
                </h6>
                <table class="table table-striped">
                    <thead class="text-start text-muted text-uppercase gs-0">
                        <tr>
                            <th>No</th>
                            <th>Payable Amount</th>
                            <th>Due Date</th>
                            <th>Payment Status</th>
                            <th>Reminder Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($user->fee->installments as $key => $installment)
                            <!-- Button trigger modal -->
                            @php
                                if (!$installment->isPaid()) {
                                    $pending_payment = 1;
                                    if ($next_payment == null) {
                                        $next_payment = $installment;
                                    }
                                } else {
                                    $pending_amount = $pending_amount - $installment->amount;
                                }
                            @endphp
                            <tr>
                                <td><a role="button">{{ $installment->current_installment }}</a></td>
                                <td>{{ $installment->amount }}</td>
                                <td>{{ $installment->payment_due_date }}</td>
                                <td> @include('common.status-badge', ['instance' => $installment]) </td>
                                <td>{{ $installment->reminder_status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    No Installments added
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @endif
        @endif
        @if (@$user != null)
            @include('admin.fees.partials.payment-btn', ['fee' => $user->fee])
        @endif

        @if (@$past_fee != null)
            <div class="accordion" id="prepay">
                <div>
                    <a id="prepay1btn" class="d-flex align-items-center my-2" data-toggle="collapse"
                        data-target="#prepay1" role="button" aria-expanded="true" aria-controls="collapseOne">
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-eye" viewBox="0 0 16 16">
                                <path
                                    d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                <path
                                    d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                            </svg><u> Previous Payments</u></span>
                    </a>
                </div>
                <div class="card mb-0">
                    <div id="prepay1" class="collapse" aria-labelledby="headingOne" data-parent="#prepay">
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead class="text-start text-muted text-uppercase gs-0">
                                    <tr>
                                        <th>No</th>
                                        <th>Payable Amount</th>
                                        <th>Installments</th>
                                        <th>Payment Status</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($past_fee as $key => $fee)
                                        <tr>
                                            <td>#{{ $fee->id }}</td>
                                            <td><a role="button">{{ priceFormatted($fee->amount) }}</a></td>
                                            <td>{{ $fee->installment_nos == 1 ? 'One Time' : $fee->installment_nos }}
                                            </td>
                                            <td> @include('common.status-badge', ['instance' => $fee]) </td>
                                        </tr>
                                        @if ($fee->installments->count() > 1)
                                            <tr class="bg-light">
                                                <td colspan="4  text-center">
                                                    <a class="text-info d-block text-center">Installment Details:</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="background: white" colspan="4" class="text-info p-0 bg-white">
                                                    <table class="table mx-auto" style="max-width: 400px;">

                                                        {{-- <thead class="text-start text-muted text-uppercase gs-0">
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Amount</th>
                                                                <th>Payment Date</th>
                                                            </tr>
                                                        </thead> --}}
                                                        @foreach ($fee->installments as $key => $installment)
                                                            <tr class="bg-light p-2 white-tr">
                                                                <td> {{ $installment->current_installment }} </td>
                                                                <td>{{ priceFormatted($installment->amount) }}</td>
                                                                <td> {{ $installment->paid_date }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        @endif
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '#prepay1btn', function(event) {
                $('#prepay1').fadeToggle();
            });
        });
    </script>
@endpush
<style>
    .white-tr td {
        background: white !important;
        border: none !important;
        color: #8b8b8b;
        font-weight: normal;
        border-color: #fff;
    }
</style>