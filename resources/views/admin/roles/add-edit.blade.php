@extends('layouts.admin.app')
@section('title', 'Edit Role')
@section('content')

    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->

        <!--begin::Card header-->
        <!--begin::Content-->
        <div id="edit_role" class="collapse show">
            <!--begin::Form-->
            <form id="roles_form" class="form" novalidate="novalidate" method="post"
                action="{{ isset($role) ? route('roles.update', $role) : route('roles.store') }}">
                <!--begin::Card body-->
                @csrf
                @isset($role)
                    @method('PUT')
                    @endif
                    <div class="card-body border-top p-9">
                        <div class="fv-row mb-5 col-md-4" maxlength="10">
                            <label class="fs-6 fw-bold form-label mb-2" for="name">@lang('Name')</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ isset($role) ? $role->name : '' }}" placeholder="@lang('Name')"
                                {{ isset($role) &&!auth()->user()->can('renamable', $role)? 'readonly': '' }}>  
                        </div>
                        <h3 class="my-5">@lang('Permissions')</h3>
                        @foreach ($permissions as $group => $grouped_permissions)
                            <div class="card card-dashed h-xl-100 p-6 mb-5 group-card">
                                <div class="align-items-center fs-5 fw-bolder mb-5">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <input class="form-check-input group-check" type="checkbox"
                                            id="group-{{ \Illuminate\Support\Str::kebab($group) }}">
                                        <label class="form-check-label"
                                            for="group-{{ \Illuminate\Support\Str::kebab($group) }}">
                                            {{ implode(' ', \Illuminate\Support\Str::ucsplit($group)) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    @foreach ($grouped_permissions as $permission)
                                        <div class="col-md-4 mb-5">
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input permission-check" type="checkbox"
                                                    value="{{ $permission->id }}"
                                                    @if (isset($role) && $role->hasPermissionTo($permission)) checked @endif
                                                    id="permission-{{ $permission->id }}" name="permissions[]">
                                                <label class="form-check-label" for="permission-{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{-- <input type="submit" value="save"> --}}
                    <!--end::Card body-->
                    <!--begin::Actions-->

                    <div class="card-body">
                        <button type="submit" class="btn btn-success text-white">
                            {{ __('Save')}}
                        </button>
                        <button type="submit" class="btn btn-primary">{{ __('Discard')}}</button>
                      </div>

                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Content-->
        </div>
    @endsection

    @push('scripts')
        <script src="{{ asset('assets/js/pages/roles/form_validation.js') }}"></script>
        <script>
            $('.group-check').change(e => {
                let el = $(e.currentTarget);
                el.closest('.group-card').find('.permission-check').prop('checked', el.prop('checked'));
            });

            function checkSelectAll(el) {
                let card = el.closest('.group-card');
                let check = card.find('.permission-check').length === card.find('.permission-check:checked').length;
                card.find('.group-check').prop('checked', check);
            }

            $('.permission-check').change(e => {
                checkSelectAll($(e.currentTarget));
            })

            //Initial check for select all checkboxes
            $('.group-card').each((i, el) => {
                checkSelectAll($(el).find('.permission-check:first'));
            })
        </script>
    @endpush
