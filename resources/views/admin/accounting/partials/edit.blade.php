@php
use Illuminate\Support\Facades\Crypt;
@endphp
@if (@$accounting == null)
    <!-- Modal -->
    <div class="modal fade" id="accountEditModal" tabindex="-1" aria-labelledby="accountEditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountEditModalLabel">Edit Accounting Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="edit-accounting-body" class="modal-body">
                    {{-- details ajaxed here --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="update_accounting" type="button" class="btn btn-success text-white" >Update Details</button>

                </div>
            </div>
        </div>
    </div>
@else


    <div class="card">
        <div class="card-body p-2">
     
          <div class="p-1 border-bottom text-muted">
            <p><strong>Category:</strong>
                {{ $accounting->category->category_label }}
                @include('common.account-badge', ['instance' => $accounting])
            </p>
            <p><strong>Amount :</strong> {{ priceFormatted($accounting->amount) }}</p>
            <p><strong>Location :</strong> {{  ($accounting->location?->name) }}</p>
            <p><strong>Created Date :</strong> {{ $accounting->date }}</p>
            @if($accounting->remarks!="")
            <p><strong>Remarks :</strong> {{ $accounting->remarks }}</p>
          @endif
            {{-- <p><strong>Branch :</strong>  {{ $accounting->location?->name }}</p> --}}
            <!-- Amount -->
          </div>
            <div class="p-3 mx-2 row">
              <h6 class="text-info text-center mt-2">Edit the Details</h6>
              <div style="display: none;" class="error_pop p-3 text-danger">
               Enter the mandatory fields!
              </div>
              <div class="text-muted">
                Please fill the fields marked (<span class="text-danger">*</span>)
              </div>
            <div class="col-sm-12 col-md-12 mx-auto ">
              <label  class="form-label mt-1">Change Category <span class="text-danger">*</span> :</label>

              <select id="edit_category_id" class="form-select form-select-lg " >
                <option disabled><b>Expense Categories</b></option>
                @foreach ($exp_categories as $category )
                <option {{ ( @$category->id == $accounting->category_id ? " selected ": "")}} value="{{ $category->id }}">{{ $category->category_label }}</option>
                @endforeach
                <option disabled><b>Income Categories</b></option>
                @foreach ($inc_categories as $category )
                <option {{ ( @$category->id == $accounting->category_id ? " selected ": "")}}  value="{{ $category->id }}">{{ $category->category_label }}</option>
                @endforeach
              </select>
               
            </div>
            <div class="col-sm-12 col-md-6  mx-auto  ">
              <label  class="form-label mt-1">Update Amount <span class="text-danger">*</span>:</label>
              <input type="text" maxlength="51" class="form-control amount" value="{{ $accounting->amount}}"   id="edit_amount" autocomplete="false" placeholder="Amount">
              <input type="hidden" value="{{ Crypt::encrypt($accounting->id)}}"   id="acc_id" >
            </div>
            <div class="col-sm-12 col-md-6  mx-auto  ">
              
              @if (auth()->user()->location_id == '')
              <label  class="form-label mt-1">Update Location <span class="text-danger">*</span>:</label>
              @php
                  $locationList = locationList();
              @endphp
              <select class="form-control" id="edit_location_id" required>
                  <option value="">Select Location</option>
                  @if (!empty($locationList))
                      @foreach ($locationList as $ll)
                          <option value="{{ $ll->id }}" {{ @$accounting->location_id }}
                              {{ isset($accounting) && $accounting->location_id == $ll->id ? 'selected' : '' }}>
                              {{ $ll->name }}</option>
                      @endforeach
                  @endif
              </select>
            @else
              <input id="edit_location_id" value="{{ auth()->user()->location_id }}" type="hidden" class="form-control"   required />
            @endif
             </div>

            <div class="col-sm-12 col-md-12  mx-auto">
              <label  class="form-label mt-1">Remarks:</label>
              <input type="text" maxlength="160"  class="form-control amount" value="{{ $accounting->remarks}}"   id="edit_remarks" autocomplete="false" placeholder="Remarks">
            </div>

            </div>
        </div>

    </div>
@endif
