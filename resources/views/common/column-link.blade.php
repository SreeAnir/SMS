@if(isset($instance) && $instance!= null)
<div class="d-flex flex-column justify-content-center">
 <a 1target="_blank" class="text-gray-800 text-hover-primary mb-1" href="{{ route($path.'.show', $instance)}}">  {{$name}} </a>
</div>
@endif