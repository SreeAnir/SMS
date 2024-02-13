@php
     $attention_needed_class ="";
    if( $instance->joining_date =="" || $instance->rfid =="" || $instance->location_id =="" ){
        $attention_needed_class =" text-danger font-weight-bold text-decoration-underline" ;
    }
@endphp
<a href="{{ route('students.show',[ $instance->id])}}">
    <span
    class="{{ $attention_needed_class}}"
    >
{{  $instance->full_name }}
    </span>
</a>