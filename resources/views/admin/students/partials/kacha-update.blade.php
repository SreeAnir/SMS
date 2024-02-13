 @if (@$user != null)
     @php
         $notice = false;
     @endphp
     <div class="card collapse1 border-light border p-2  shadow-sm rounded mini-table" id="updateKacha">
         <table class="table w-100 mx-auto  ">
             <tbody>
                 <tr>
                     <th colspan="3" scope="col">
                         <h6 class="text-center text-secondary  d-flex justify-content-between border-bottom py-2  ">
                             <span><i class="fas fa-id-badge"></i> {{ __('Update Kacha') }}</span>
                             <label id="katcha_label" class="px-2">
                                 @if (@$user->student->kacha_id > 0)
                                     @include('common.kacha-badge', ['instance' => $user->student])
                                 @endif
                             </label>
                         </h6>
                         <span
                             class="text-info font-weigh-normal">{{ __('You can update the student\'s Kacha from here.Student will recieve an email regarding this change.') }}
                         </span>
                     </th>

                 </tr>
                 <tr>
                     <th scope="col" width="30%">{{ __('Total Classes') }} : {{ @$user?->student?->class_count }}
                     </th>
                 </tr>
                 @if ($kachas->count() > 0)

                     <tr>
                         <th scope="col">{{ __('Kacha') }}</th>
                         <th scope="col" id="kacha_select">
                             <select class="form-control" name="kacha_id" id="kacha_id">
                                 <option value="">{{ __('Choose Next Kacha') }}</option>
                                 @foreach ($kachas as $kacha)
                                     @php
                                         if (( $current_kacha_class >= $kacha->class_count && $kacha->class_count > 0 )&& $user?->student?->class_count > 0) {
                                             $notice = true;
                                         }
                                     @endphp
                                     <option value="{{ $kacha->id }}" data-attr="{{ $kacha->id }}"
                                         @if ($kacha->id == $user->student->kacha_id) selected @endif>{{ $kacha->next_label }}
                                         ({{ $kacha->class_count }} Classes)
                                     </option>
                                 @endforeach
                             </select>
                         </th>
                     </tr>
                 @else
                     <tr>
                         <th colspan="3" scope="col">
                             <h6 class="border border-success shadown-sm text-success p-3 mt-3 w-100 text-center"><i
                                     class="fas fa-check-circle"></i> Student has achieved
                                 all the kachas</h6>
                         </th>
                     </tr>
                 @endif
             </tbody>
         </table>
         <div class="p-3 d-flex justify-content-start">

             <button class="btn btn-warning text-white mr-1" type="button" id="save_kacha">
                 @lang('Update Kacha')
             </button>
             <button class="btn btn-dark mx-1" type="button" id="reset_kacha">
                 @lang('Cancel')
             </button>
             @if (@$notice)
                 <span class="text-center    text-danger  mx-1 px-1 ">
                     <i class="fas fa-exclamation-triangle"></i> Student is elegible for the next kacha.
                 </span>
             @endif
         </div>

     </div>
 @endif
 @push('scripts')
     <script>
         $(document).ready(function() {
             document.getElementById('save_kacha').addEventListener('click', function() {
                 swalConfirm('', "Proceed with student kacha updation ?").then((result) => {
                     if (result.isConfirmed) {
                         swalLoader();
                         saveStudentKacha();

                     } else if (result.isDenied) {
                         swalError('You have cancelled the student update!', 'Cancelled', '');
                     }
                 });

             });

             document.getElementById('reset_kacha').addEventListener('click', function() {
                 location.reload();
             });
         });

         function saveStudentKacha() {
             if ($('#kacha_id').val() == "") {
                 swalError("No Kacha selected.Please Choose the Kacha.");
                 return false;
             }
             console.log("kd", $('#kacha_id').val());
             let data = {
                 "kacha_id": $('#kacha_id').val(),
                 "student_id": "{{ $user->student->id }}",
             };
             $.ajax({
                 url: "{{ route('save.student.kacha') }}",
                 type: 'post',
                 data: data,
                 success: function(response) {
                     if (response.status == 'error') {
                         swalError(response.message);
                     } else {
                         $('#katcha_label').html(response.html);
                         swalSuccess(response.message);
                     }

                 },
                 error: function(xhr, status, error) {
                     if (xhr.responseJSON && xhr.responseJSON.message) {
                         swalError("Error", xhr.responseJSON.message);
                     } else {
                         swalError("Error", "Failed to proceed");
                     }
                     $('input[name="email"]').val('{{ @$user->email }}');
                 }
             });
         }

         function loadBatches(location_id) {
             $.ajax({
                 url: "{{ route('load.batches') }}",
                 type: 'post',
                 data: {
                     "location_id": location_id
                 },
                 success: function(response) {
                     if (response.status == 'error') {
                         swalError(response.message);
                     } else {
                         $('#batch_select').html(response.html);
                     }

                 },
                 error: function(xhr, status, error) {
                     if (xhr.responseJSON && xhr.responseJSON.message) {
                         swalError("Error", xhr.responseJSON.message);
                     } else {
                         swalError("Error", "Failed to proceed");
                     }
                     $('input[name="email"]').val('{{ @$user->email }}');
                 }
             });
         }
     </script>
 @endpush
