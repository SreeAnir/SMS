<!--begin::Image input-->
<div class="image-input @if(!$attributes->get('value')) image-input-empty @endif" data-kt-image-input="true"
     @if(!$attributes->get('image_type')) 
     style="background-image: url({{asset('/assets/media/svg/avatars/blank.svg')}})"
     @else 
     style="background-image: url({{asset('/assets/media/svg/files/blank-image.svg')}})"
     @endif
     >

    <!--begin::Image preview wrapper-->
    <div class="image-input-wrapper w-125px h-125px"
         @if($attributes->get('value'))
         style="background-image: url({{$attributes->get('value')}})"
            @endisset
    ></div>
    <!--end::Image preview wrapper-->

    <!--begin::Edit button-->
    <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
           data-kt-image-input-action="change"
           data-bs-toggle="tooltip"
           data-bs-dismiss="click" 
           title="{{ ($attributes->get('image_edit_text') ? : 'Change avatar') }}" >
        <i class="bi bi-pencil-fill fs-7"></i>

        <!--begin::Inputs-->
        <input type="file" name="{{$getName()}}" accept=".png, .jpg, .jpeg"/>
        <input type="hidden" name="remove_file_{{$getName()}}"/>
        <!--end::Inputs-->
    </label>
    <!--end::Edit button-->

    <!--begin::Cancel button-->
    <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
          data-kt-image-input-action="cancel"
          data-bs-toggle="tooltip"
          data-bs-dismiss="click"
          title="{{ ($attributes->get('image_cancel_text') ? : 'Cancel avatar') }}">
         <i class="bi bi-x fs-2"></i>
     </span>
    <!--end::Cancel button-->

    <!--begin::Remove button-->
    <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
          data-kt-image-input-action="remove"
          data-bs-toggle="tooltip"
          data-bs-dismiss="click"
          title="{{ ($attributes->get('remove_text') ? : 'Remove avatar') }}">
         <i class="bi bi-x fs-2"></i>
     </span>
    <!--end::Remove button-->
</div>
<!--end::Image input-->