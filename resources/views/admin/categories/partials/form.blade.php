@php
    use App\Models\AccountingCategory ;
    use App\Models\Status ;
@endphp
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <form
                action="{{ isset($accountingCategory) ? route('accounting-categories.update', [$accountingCategory]) : route('accounting-categories.store') }}"
                class="form-horizontal" method="POST" id="create-category">
                @csrf
                <div class="card-body">
                     
                    @if (isset($accountingCategory))
                        {{ method_field('PUT') }}
                    @endif
                    <h4 class="card-title">@lang('Category Info')</h4>

                    <div class="card-body border-top p-9">

                        <div class="row">

                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="category_type">@lang('Category Type')</label>
                                    <select class="form-control" placeholder="{{ __('Category Type') }}"   name="category_type">
                                        <option value="">{{ __('Choose Type') }}</option>
                                        <option  {{  AccountingCategory::INCOME == @$accountingCategory->category_type ? " selected ='selected' " : '' }}  value="{{ AccountingCategory::INCOME}}">{{ __('Income') }}</option>
                                        <option   {{  AccountingCategory::EXPENSE == @$accountingCategory->category_type ? " selected ='selected' " : '' }}  value="{{ AccountingCategory::EXPENSE}}">{{ __('Expense') }}</option>
                                         
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="last_name">@lang('Category Label')</label>
                                    <input maxlength="120" type="text" class="form-control"
                                        value="{{ isset($accountingCategory) ? $accountingCategory->category_label : old('category_label') }}"
                                        name="category_label" placeholder="Category label"  >
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="last_name">@lang('Category Description')</label>
                                    <textarea maxlength="150" rows="2" type="text" class="form-control" name="category_description"
                                        placeholder="Category Description">{{ isset($accountingCategory) ? $accountingCategory->category_description : old('category_description') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="last_name">@lang('Category Status')</label>
                                  
                                    <select class="form-control" placeholder="{{ __('Category Status') }}"   name="status_id">
                                        <option value="">{{ __('Choose Status') }}</option>
                                        <option  {{  Status::STATUS_ACTIVE == @$accountingCategory->status_id ? " selected ='selected' " : '' }}  value="{{ Status::STATUS_ACTIVE}}">{{ __('Active') }}</option>
                                        <option   {{  Status::STATUS_INACTIVE == @$accountingCategory->status_id ? " selected ='selected' " : '' }}  value="{{ Status::STATUS_INACTIVE}}">{{ __('Inactive') }}</option>
                                         
                                    </select>
                                    </div>
                            </div>
                        </div>

                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            <input type="submit" value="Save Details" class="btn btn-primary">
                            <input type="reset" value="Reset Details" class="btn btn-secondary">
                        </div>
                    </div>
            </form>

        </div>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
        <script>
            window.addEventListener('load', function() {

                $('#create-category').validate({
                    rules: {
                        category_type:{
                            required: true,
                            minlength: 1,
                        },
                        category_label: {
                            required: true,
                            maxlength: 120,
                        },

                        category_description: {
                            maxlength: 150,
                        },
                    },
                    messages: {
                        category_label: {
                            required: 'Category label is required',
                            maxlength: "Category label cannot be more than 15 characters"
                        },
                        category_description: {
                            required: "Category description is required",
                            maxlength: "Category description cannot be more than 100 characters"
                        },
                    },
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    }
                });

            });
            $(document).ready(function() {
               
            });
        </script>
    @endpush
