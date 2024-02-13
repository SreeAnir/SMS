@php
    use App\Models\NotificationUser;
@endphp
<div class="container theme-border top-section">

     <section>
         <div class="row">
             <div class="col-lg-2 col-sm-4 ">
                 <div class="text-center profile-img">
                     <img class="rounded-circle" src="{{ auth()->user()->profile_photo_url }} " alt="Profile Picture">
                 </div>
                 <div class="text-center profile-img w-100 p-0 m-0">
                     <span role="button" id="upload_photo" class="text-info text-underline">Update Photo</span>
                 </div>
                 <div class="d-none">
                     <form id="update_img_form" action="{{ route('update.dp') }}" method="post"
                         enctype="multipart/form-data">
                         @csrf
                         <input accept="image/*" id="upload_photo_input" type="file" name="profile_photo">
                     </form>
                 </div>
             </div>
             <div class="col-lg-6  col-sm-8">
                 <h5 class="text-uppercase font-weight-bold"><b>{{ auth()->user()->full_name }} </b> 
                    @include('common.kacha-badge', ['instance' => $user?->student])
                </h5>
                 <p class="text-muted">Student ID: {{ auth()->user()->ID_Number }} |  Joined on
                     {{ auth()->user()->joining_date }} | Classes
                     {{ auth()->user()->student->class_count }} </p>
                 <div class=" border-top d-flex flex-row py-2">
                     <div class="col-6 p-1 mr-1">
                         <ul class="list-group list-group-flush border-none border-less">
                             <li class="list-group-item list-profile-item py-1">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                     fill="currentColor" class="bi bi-envelope-at" viewBox="0 0 16 16">
                                     <path
                                         d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2zm3.708 6.208L1 11.105V5.383zM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2z" />
                                     <path
                                         d="M14.247 14.269c1.01 0 1.587-.857 1.587-2.025v-.21C15.834 10.43 14.64 9 12.52 9h-.035C10.42 9 9 10.36 9 12.432v.214C9 14.82 10.438 16 12.358 16h.044c.594 0 1.018-.074 1.237-.175v-.73c-.245.11-.673.18-1.18.18h-.044c-1.334 0-2.571-.788-2.571-2.655v-.157c0-1.657 1.058-2.724 2.64-2.724h.04c1.535 0 2.484 1.05 2.484 2.326v.118c0 .975-.324 1.39-.639 1.39-.232 0-.41-.148-.41-.42v-2.19h-.906v.569h-.03c-.084-.298-.368-.63-.954-.63-.778 0-1.259.555-1.259 1.4v.528c0 .892.49 1.434 1.26 1.434.471 0 .896-.227 1.014-.643h.043c.118.42.617.648 1.12.648Zm-2.453-1.588v-.227c0-.546.227-.791.573-.791.297 0 .572.192.572.708v.367c0 .573-.253.744-.564.744-.354 0-.581-.215-.581-.8Z" />
                                 </svg>
                                 <span class="mx-1">{{ auth()->user()->email }}</span>
                             </li>

                             <li class="list-group-item list-profile-item py-1">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                     fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                     <path fill-rule="evenodd"
                                         d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                                 </svg>

                                 <span class="mx-1"> {{ auth()->user()->full_phonenumber }} </span>
                             </li>

                             <li class="list-group-item list-profile-item py-1">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                     fill="currentColor" class="bi bi-cake" viewBox="0 0 16 16">
                                     <path
                                         d="m7.994.013-.595.79a.747.747 0 0 0 .101 1.01V4H5a2 2 0 0 0-2 2v3H2a2 2 0 0 0-2 2v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a2 2 0 0 0-2-2h-1V6a2 2 0 0 0-2-2H8.5V1.806A.747.747 0 0 0 8.592.802l-.598-.79ZM4 6a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v.414a.911.911 0 0 1-.646-.268 1.914 1.914 0 0 0-2.708 0 .914.914 0 0 1-1.292 0 1.914 1.914 0 0 0-2.708 0A.911.911 0 0 1 4 6.414zm0 1.414c.49 0 .98-.187 1.354-.56a.914.914 0 0 1 1.292 0c.748.747 1.96.747 2.708 0a.914.914 0 0 1 1.292 0c.374.373.864.56 1.354.56V9H4zM1 11a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.793l-.354.354a.914.914 0 0 1-1.293 0 1.914 1.914 0 0 0-2.707 0 .914.914 0 0 1-1.292 0 1.914 1.914 0 0 0-2.708 0 .914.914 0 0 1-1.292 0 1.914 1.914 0 0 0-2.708 0 .914.914 0 0 1-1.292 0L1 11.793zm11.646 1.854a1.915 1.915 0 0 0 2.354.279V15H1v-1.867c.737.452 1.715.36 2.354-.28a.914.914 0 0 1 1.292 0c.748.748 1.96.748 2.708 0a.914.914 0 0 1 1.292 0c.748.748 1.96.748 2.707 0a.914.914 0 0 1 1.293 0Z" />
                                 </svg>
                                 <span class="mx-1"> {{ auth()->user()->dob }} </span>
                             </li>
                         </ul>

                     </div>
                     <div class="col-md-6 col-sm-12 p-1">
                         <ul class="list-group list-group-flush border-none border-less">
                             <li class="list-group-item"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                     height="16" fill="currentColor" class="bi bi-front" viewBox="0 0 16 16">
                                     <path
                                         d="M0 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2h2a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-2H2a2 2 0 0 1-2-2zm5 10v2a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1h-2v5a2 2 0 0 1-2 2z" />
                                 </svg> <span class="mx-1">Emirates ID :
                                     {{ auth()->user()->student->emirates_id }}</span></li>
                             <li class="list-group-item">

                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                     fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                     <path
                                         d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10" />
                                     <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                 </svg>

                                 <span class="mx-1">{{ auth()->user()->country->name }} </span>
                             </li>
                         </ul>
                     </div>
                 </div>
             </div>
             <div class="col-lg-4 font-small">
                 <div class="p-2 font-small bg-light shadow-sm bg-white rounded ">
                 <p class="text-center text-dark"><span>Notice board</span></p>
                        @php 
                        $recent_notifications =  NotificationUser::with('notification')->where('user_id' , auth()->user()->id )->orderBy('created_at', 'desc')->first();
                        @endphp
                        @if( $recent_notifications!=null )
                         <p class="p-2">{{ $recent_notifications->notification->title }}</p>
                        @else
                         <p class="font-small p-2">No new notification</p>
                        @endif
                 </div>

             </div>
         </div>


     </section>
 </div>

 @include('student.includes.profile_image')

 @push('scripts')
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
     <script>
         function readURL(input) {
             if (input.files && input.files[0]) {
                 var reader = new FileReader();
                 reader.onload = function(e) {
                     $('#previewImage').attr('src', e.target.result);
                 }
                 reader.readAsDataURL(input.files[0]);
             }
         }
         $(document).ready(function() {
             $(document).on('click', '#upload_photo', function(e) {
                 $('#upload_photo_input').trigger('click');
             });
             $(document).on('change', '#upload_photo_input', function(e) {
                 readURL(this);
                 $('#profileImgModal').modal('show');
             });
             $(document).on('click', '#update_confirm', function(e) {
                 $('#update_img_form').submit();
             });

         });
     </script>
 @endpush
