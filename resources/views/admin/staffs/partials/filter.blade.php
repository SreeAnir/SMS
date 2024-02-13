<form method="post" action="#" id="user_filter_form">
    @csrf
    <div class="row mt-3">
        <div class="row">
            {{-- @if (str_contains(url()->current(),'app-users')==false)
            <div class="col-md-4">
                <x-form.select2 label="{{__('Role')}}" text_key="name"
                                name="role"
                                :options="App\Models\Role::where('name', '!=',App\Models\Role::ROLE_DEVELOPER)->get()"
                                value="3"
                                placeholder="{{__('Select Role')}}"></x-form.select2>
            </div>
            @endif
           
            <div class="col-md-4">
                <x-form.select2 label="{{__('Status')}}" text_key="status"
                                name="status"
                                :options="App\Models\Status::list()"
                                placeholder="{{__('Select Status')}}"></x-form.select2>
            </div> --}}
        </div>
    </div>
</form>
