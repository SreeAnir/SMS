<form method="post" action="#" id="user_filter_form">
    @csrf
    <div class="row mt-3">
        <div class="row">

            <div class="col-md-4">
                <div class="fv-row">
                    <select class="form-control" name="role" id="role">
                        <option value="">{{ __('Choose Role') }}</option>
                        @foreach (App\Models\Role::getRoles() as $option)
                            <option value="{{ $option['id'] }}" data-attr="{{ $option['id'] }}"
                                @if ($option['selected']) selected @endif>{{ $option['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="fv-row">
                    <select class="form-control" name="status_id" id="status_id">
                        <option value="">{{ __('Choose Status') }}</option>
                        @foreach (App\Models\Status::list() as $option)
                            <option value="{{ $option['id'] }}" data-attr="{{ $option['id'] }}"
                                @if ($option['selected']) selected @endif>{{ $option['status'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>
    </div>
</form>
{{-- @push('scripts')
    <script>
    $(document).ready(function() {
        $('#role').on('change', function() {
            var selectedValue = $(this).val();
            
            $('#users-table').DataTable().column(0).search('sdfsd=ksdjfsd&dhf=sdjfhs').draw();
            
        });
    });
     
    </script>
@endpush --}}
