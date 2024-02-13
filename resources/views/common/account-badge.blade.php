  @php
    use App\Models\AccountingCategory;
  @endphp
  @if( AccountingCategory::INCOME == $instance->acc_type  )
  <span class="badge bg-success  status-badge fs-8 fw-bolder">
      {{ $instance->category_type_label }}
  </span>
  @else 
  <span class="badge bg-danger  status-badge fs-8 fw-bolder">
    {{ $instance->category_type_label }}
</span>
  @endif
{{--   
  <option  {{  AccountingCategory::INCOME == @$accountingCategory->category_type ? " selected ='selected' " : '' }}  value="{{ AccountingCategory::INCOME}}">{{ __('Income') }}</option>
  <option   {{  AccountingCategory::EXPENSE == @$accountingCategory->category_type ? " selected ='selected' " : '' }}  value="{{ AccountingCategory::EXPENSE}}">{{ __('Expense') }}</option>
    --}}