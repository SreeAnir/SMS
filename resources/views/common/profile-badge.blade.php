@if(isset($imageUrl) && $imageUrl != null)

    <div class="d-flex align-items-center">
        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
            <div class="symbol-label">
                <img src="{{$imageUrl}}" class="w-100">
            </div>
        </div>
        <div class="d-flex flex-column">
            <a class="text-gray-800 text-hover-primary mb-1" href="{{route('admin.'.$path.'.show', $instance)}}">{{$name}}</a>
            </div>
    </div>
@elseif(isset($imageUrl) )
    <div class="d-flex align-items-center">
        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
            <div class="symbol-label">
                <img src="{{asset('assets/media/misc/image.png')}}" class="w-100">
            </div>
        </div>
        <div class="d-flex flex-column">
            <a class="text-gray-800 text-hover-primary mb-1" href="{{route('admin.'.$path.'.show', $instance)}}">{{$name}}</a>
        </div>
    </div>

@else

    <div class="d-flex align-items-center">
        <div class="d-flex flex-column">
            <a class="text-gray-800 text-hover-primary mb-1" href="{{route('admin.'.$path.'.show', $instance)}}">{{$name}}</a>
        </div>
    </div>
@endif