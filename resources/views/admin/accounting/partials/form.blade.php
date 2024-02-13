@php
    use App\Models\AccountingCategory;
    use App\Models\Status;
@endphp
<div class="row">
     
    <div class="col-md-12">
        @if( @$todays_telr !="" )
        <div class="card">
            <div class="card-body"> 
                <div class="alert alert-info">
                 There is  {{ $todays_telr}} fee payments from online Telr payment.<a target="_blank" href="{{ route('accounting.index')}}">Review Details</a>
                </div>
            </div>
        </div>
        @endif
        <div class="card">
            <form
                action="{{ isset($accountingCategory) ? route('accounting.update', [$accountingCategory]) : route('accounting.store') }}"
                class="form-horizontal" method="POST" id="create-accounting">
                @csrf
                <div class="card-body">

                    @if (isset($accountingCategory))
                        {{ method_field('PUT') }}
                    @endif
                    <h4 class="card-title">@lang('Income & Expenses')</h4>

                    <div class="card-body">
                        <div class="card-body border-top p-9">
                            <h4 class= "p-2 bg-light">Income</h4>
                            @foreach ($categories_income as $key => $category)
                                <div class="form-group row">

                                    <div class="col-md-3 col-sm-12 ">
                                        {{ $category->category_label }}
                                        <input type="hidden" maxlength="2" class="form-control"
                                            value="{{ $category->id }}" name="income[{{ $key }}][category_id]"
                                            id="category_{{ $category->id }}" autocomplete="false">
                                    </div>
                                    <div class="col-md-2 col-sm-12 ">
                                        <input type="text" maxlength="5" class="form-control amount"
                                            value="{{ old('income.' . $key . '.amount') }}"
                                            name="income[{{ $key }}][amount]" id="amount_{{ $category->id }}"
                                            autocomplete="false" placeholder="Amount">
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <input type="text" maxlength="160" class="form-control"
                                            value="{{ old('income.' . $key . '.remarks') }}"
                                            name="income[{{ $key }}][remarks]"
                                            id="remarks_{{ $category->id }}" autocomplete="false"
                                            placeholder="Remarks">
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <div class="card-body border-top p-9">

                            <h4 class=" p-2 bg-light">Expense</h4>
                            @foreach ($categories_expense as  $key => $category)
                                {{-- <div class="form-group row">

                                    <div class="col-md-2 col-sm-12 ">
                                        {{ $category->category_label }}
                                        <input type="hidden" maxlength="2" class="form-control"
                                            value="{{ $category->id }}"
                                            name="expense[{{ $key }}][category_id]"
                                            id="category_{{ $category->id }}" autocomplete="false">
                                    </div>
                                    <div class="col-md-2 col-sm-12 ">
                                        <input type="text" maxlength="160" class="form-control amount"
                                            value="{{ old('expense.' . $key . '.amount') }}"
                                            name="expense[{{ $key }}][amount]"
                                            id="amount_{{ $category->id }}" autocomplete="false" placeholder="Amount">
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <input type="text" maxlength="160" class="form-control"
                                            value="{{ old('expense.' . $key . '.remarks') }}"
                                            name="expense[{{ $key }}][remarks]"
                                            id="remarks_{{ $category->id }}" autocomplete="false"
                                            placeholder="Remarks">
                                    </div>
                                </div> --}}

                                <div class="form-group row">

                                    <div class="col-md-3 col-sm-12 ">
                                        {{ $category->category_label }}
                                        <input type="hidden" maxlength="2" class="form-control"
                                            value="{{ $category->id }}" name="expense[{{ $key }}][category_id]"
                                            id="category_{{ $category->id }}" autocomplete="false">
                                    </div>
                                    <div class="col-md-2 col-sm-12 ">
                                        <input type="text" maxlength="160" class="form-control amount"
                                            value="{{ old('expense.' . $key . '.amount') }}"
                                            name="expense[{{ $key }}][amount]" id="amount_{{ $category->id }}"
                                            autocomplete="false" placeholder="Amount">
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <input type="text" maxlength="160" class="form-control"
                                            value="{{ old('expense.' . $key . '.remarks') }}"
                                            name="expense[{{ $key }}][remarks]"
                                            id="remarks_{{ $category->id }}" autocomplete="false"
                                            placeholder="Remarks">
                                    </div>
                                </div>

                            @endforeach
                        </div>
                    

                    <div class="">
                        <div class="card-body">
                            <div class="col-12 d-flex justify-content-center">
                                <input style="width: 50%" type="submit" value="Compute" class="btn btn-primary buttons">
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="border-top">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label"> Net Revenue (AED)</label>
                                <div class="col-4">
                                    <label for="inputPassword" class="col-form-label font-weight-bold  text-danger"> {{ $net_revenue }} (AED)</label>
                                    {{-- <input type="text" readonly maxlength="160"
                                        class="form-control border font-weight-bold" id="net_revenue"
                                        value="{{ $net_revenue }}" autocomplete="false" placeholder="Net Revenue"> --}}
                                </div>
                            </div>


                        </div>
                    </div>
            </form>

        </div>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.buttons').attr('disabled', true);
                $('.amount').change(function() {
                    var typedValue = $(this).val();
                    if (isNaN(typedValue) && typedValue != null) {
                        swalSuccess("Please enter a valid number.", 'Done').then((result) => {
                            $('.buttons').attr('disabled', true);
                        });
                    } else {
                        $('.buttons').removeAttr('disabled');
                    }
                    calculateNetRevenue();
                });

                function calculateNetRevenue() {

                    let incomeAmountInputs = $('input[name^="income"][name$="[amount]"]:filled');
                    let income_amts = 0;
                    incomeAmountInputs.each(function(index, element) {
                        if ($(element).val() != null) {
                            income_amts = income_amts + parseFloat($(element).val());
                        }
                    });

                    let expenseAmountInputs = $('input[name^="expense"][name$="[amount]"]:filled');
                    let expense_amts = 0;
                    expenseAmountInputs.each(function(index, element) {
                        if ($(element).val() != null) {
                            expense_amts = expense_amts + parseFloat($(element).val());
                        }

                    });
                    console.log(income_amts);
                    console.log(expense_amts);


                }

                $(document).ready(function() {
                     
                    $('.amount:not(:filled)').val(0);
                    $('#create-accounting').submit(function(event) {
                        if ($('.amount:filled', this).length === 0) {
                            swalSuccess("Please enter at least one value before submitting.", 'Done')
                                .then((result) => {
                                    $('.buttons').attr('disabled', true);
                                });
                            event.preventDefault();
                        }
                    });
                });

            });
        </script>
    @endpush
