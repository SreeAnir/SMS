
<div class="p-1">
    <p class="text-info p-3"> <h6>Showing Records of {{ @($year_month !="" ?  $year_month : "current month")}} , Branch -{{ @($searched_location !="" ?  $searched_location->name : "All Branches")}}  </h4></p>
</div>
@if($users->count()  == 0)
<div class="alert alert-danger">
No Records Found
</div>
@else 
<div class="table-responsive">
    <table class="table table-bordered table-responsive">
        <thead>
            <tr class="font-weight-bold">
                <th scope="col">#</th>
                <th scope="col" >Name</th>
                @foreach ($days as $day)
                <th scope="col">{{ $day }}</th>
                @endforeach

            </tr>
        </thead>
        <tbody>
            
            @foreach ($users as $key=> $user)
            <tr>
                <th scope="row">{{ $key +1 }}</th>
                @php
                    $rt = (  $user->isStaff()  ? route('staffs.show',[$user->id ] ):  route('students.show',[$user->id ] ) ) ;
                @endphp
                <td   ><a href="{{ $rt}}">{{ $user->full_name }}</a></td>
                @foreach ($days as $day)
                @php
                $present_days =[];
                if( $user->rfid !="" &&  count($attendance_data) > 0){
                    if(isset($attendance_data[ $user->rfid])){
                        $present_days =  explode( ',',$attendance_data[ $user->rfid]);
                    }
                } 
                @endphp
                <td class="p-0 
                @if( count($present_days) > 0 &&  in_array( $day , $present_days  ))
                bg-success
                @endif
                ">
                   
                </td>
                @endforeach
            </tr>
            @endforeach

        </tbody>
    </table>
</div>
@endif 
