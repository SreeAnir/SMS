@extends('layouts.admin.app')
@section('title','Role details')
@section('content')

<div class="col-12">
    <div class="row row-cards">
      <div class="col-sm-12 col-lg-12">
        <div class="card card-sm">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="bg-primary text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" /><path d="M12 3v3m0 12v3" /></svg>
                </span>
              </div>
              <div class="col">
                <div class="font-weight-medium">
                    {{$role->name}}
                </div>
                <div class="text-secondary"> 
                    {{$role->description}}
                </div>
              </div>
              <div >
                <a href="{{route('roles.edit',$role)}}" class="btn btn-light btn-active-primary">
                    @lang('Edit Role')
                </a>
                @can('delete',$role)
                    <form class="delete-form d-inline-block ms-1" action="{{route('roles.destroy',$role)}}"
                          method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">@lang('Delete Role')</button>
                    </form>
                @endcan
              </div>
            </div>
                   
                {{-- @can('delete',$role)
                    <form class="delete-form d-inline-block ms-1" action="{{route('roles.destroy',$role)}}"
                          method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">@lang('Delete Role')</button>
                    </form>
                @endcan --}}
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-lg-12">
    <div class="tab-pane fade show active" id="role_permissions" role="tabpanel">
        <div class="card">
            <div class="card-body">
                <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="table-responsive">
                        <table class="table table-row-bordered table-row-dashed gy-4 align-middle dataTable no-footer">
                            <thead class="fs-7 fw-bolder text-gray-400 text-uppercase">
                                <th>@lang('Group')</th>
                                <th>@lang('Previleges')</th>
                                <th>@lang('Status')</th>
                            </thead>
                            <tbody>
                                @foreach($permissions as $key => $permission)
                                    <tr>
                                        @if($key==0)
                                            <?php $prev= $permission->group;?>
                                            <th rowspan="{{$permission->rowscnt}}">{{$permission->group}} </th>
                                        @else
                                        @if($permission->group!= $prev)
                                            <th rowspan="{{$permission->rowscnt}}">{{$permission->group}}</th>
                                            <?php $prev= $permission->group;?>
                                        @else
                                            <?php $prev= $permission->group;?>
                                                <th rowspan="{{$permission->rowscnt}}"></th>
                                            @endif
                                        @endif
                                        <td>{{$permission->name}}</td>
                                        <td>
                                            @if($role->hasPermissionTo($permission) )
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                                            @else 
                                            <i class="seticon mdi mdi-close text-danger" aria-hidden="true"></i>
                                            @endif
                                        </td>
                                    </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@push('scripts')
    <script>
        $('.delete-form button').click(e => {
            e.preventDefault();
            
            let form = $(e.currentTarget).closest('form');
            let url = form.attr('action');
            Swal.fire({
                title: form.data('title') ?? `Are you sure?`,
                html: form.data('message') ?? 'Are you sure you want to delete this role?',
                icon: "question",
                buttonsStyling: false,
                showCancelButton: true,
                confirmButtonText: form.data('confirm-label') ?? "Yes, delete it!",
                cancelButtonText: form.data('cancel-label') ?? 'No, cancel!',
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: 'btn btn-light-primary btn-active-light-danger'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    swalLoader();
                    form.submit();
                }
            });
        })
    </script>
@endpush