<?php
namespace App\Services;
use Illuminate\Database\Eloquent\Builder;

// use App\Models\EpushServerModel;
use App\Models\{DeviceLog, KachaStudent, User , Student};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Carbon\Carbon;
use DateTime;

class DataSyncService
{
    public function syncData__($user_ids='0', $date ="")
    {

    try {
        $table = $this->generateTableName($date) ;

        if($date ==null){
            $date = now()->toDateString();
        }

        // Fetch data from the external database
        echo "Now :". $date .'<br/>';
        DB::beginTransaction();

        $logged_in_today =  DeviceLog::whereDate('log_date',$date )->pluck('rfid')->implode(',');
        $last_fetched = DeviceLog::latest()->first();
        $user_ids = User::where('rfid','>',0)->whereNotIn('rfid',[$logged_in_today])->pluck('rfid')->implode(',');
        $query = "select * from ".$table." where UserId IN($user_ids)";
        if($last_fetched !=null ){
            $query .= " AND (LogDate) >   '".DATE($last_fetched->log_date)."' AND DATE(LogDate) = '". $date ."' ";
        }

        $externalData =  DB::connection('epushserver')->select($query);
        // $create = [];
        $user_insert =array();
        foreach ($externalData as $data) {
           
            if( $data->Direction!="" && in_array(  $data->UserId , $user_insert) == false  ){
                
                if(!DeviceLog::where( "rfid"  ,  $data->UserId )->whereDate('log_date', $data->LogDate)->exists()){
                    $create_record= array( "log_date" =>  $data->LogDate  , "rfid" => $data->UserId , "direction" => $data->Direction  );
                    if(DeviceLog::create($create_record)){
                        array_push( $user_insert , (int) $data->UserId );
                    }
                } 

                echo "log_date ". $data->LogDate ."for " .$data->UserId ." //// \n" ;
            }
        } 
        $student_ids = Student::whereIn('user_id', function ($query) use ($user_insert) {
            $query->select('id')->from('users')->whereIn('rfid', $user_insert);
        })->get()->pluck('id')->toArray();

       if(count($student_ids) > 0 ){

        $update_class = Student::whereIn('id', $student_ids )->update(['class_count' => DB::raw('class_count + 1')]);

        $class_count_update = KachaStudent::whereIn('student_id', $student_ids )
        ->whereIn('id', function ($query) {
            $query->select(DB::raw('MAX(id)'))
                ->from('kacha_students')
                ->groupBy('student_id');
        })
        ->update(['class_count' => DB::raw('class_count + 1')]);
          Log::info('Log added for '.implode(',', $student_ids).' at '.$date );
          if(  $class_count_update  ){
              Log::info('class count updated' );
  
          }
        }
        else{
          Log::info('No Update Available for student log' );
        }
        Log::info('RFIDS Log:'.implode(',', $user_insert).' at '.$date );
        
        Log::info('****** ****** ******* \n\n' );
        DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Update operation failed syncData(): ' . $e->getMessage().'on ' .$e->getLine());
        }
    }

    function isDateString($dateString, $format = 'Y-m-d') {
        try {
            $date = Carbon::createFromFormat($format, $dateString);
            return $date && $date->format($format) === $dateString;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function syncData($user_ids='0', $date ="")
    {
    try {
        if($date ==null){
            $date = now()->toDateString();
            $table_name = $this->generateTableName() ;
        }else{
            $table_name = $this->generateTableName($date) ;
        }
        if ( !$this->isDateString($date)) {
            echo "Not a Valid Date!<br />";
            return ;
        }

        $fetched_already =  DeviceLog::whereDate('log_date',$date )->pluck('rfid')->implode(',');
        $query = "select * from ".$table_name." ";
        $query .= " where   DATE(LogDate) = '". $date ."' ";
        if( $fetched_already !="" ){
            $query .= "AND  UserId NOT IN($fetched_already)";
        }

        if(  $user_ids  !='0' ){
            $query .= " AND  UserId IN($user_ids)";
        }

        
        $externalData =  DB::connection('epushserver')->select($query);
        DB::beginTransaction();

        $user_insert =array();
        
        foreach ($externalData as $data) {
           
            if( $data->Direction!="" && in_array(  $data->UserId , $user_insert) == false  ){
                    $create_record= array( "log_date" =>  $data->LogDate  , "rfid" => $data->UserId , "direction" => $data->Direction  );
                    if(DeviceLog::create($create_record)){
                        array_push( $user_insert , (int) $data->UserId );
                    }
                echo "log_date ". $data->LogDate ."for " .$data->UserId ." //// \n" ;
            }
        } 


        $students = Student::whereIn('user_id', function ($query) use ($user_insert) {
            $query->select('id')->from('users')->whereIn('rfid', $user_insert);
        })->get();
        $student_ids = $students->pluck('id')->toArray();

       if(count($student_ids) > 0 ){

        $update_class = Student::whereIn('id', $student_ids )->update(['class_count' => DB::raw('class_count + 1')]);

        // $class_count_update = KachaStudent::whereIn('student_id', $student_ids )
        // ->whereIn('kacha_id ', function ($query) {
        //     $query->select(DB::raw('MAX(id)'))
        //         ->from(DB::raw('(SELECT * FROM kacha_students) AS kacha_students_temp'))
        //         ->groupBy('student_id');
        // })
        // ->update(['class_count' => DB::raw('class_count + 1')]);
        $class_count_update = [];
             
            foreach($students as $student){
                KachaStudent::where('id', $student->id )->where('kacha_id', $student->kacha_id )->update(['class_count' => DB::raw('class_count + 1')]);
                $class_count_update[]= $student->kacha_id."-".$student->id;
            }
          Log::info('Log added for '.implode(',', $student_ids).' at '.$date );
          if( count( $class_count_update) > 0   ){
              Log::info('class count updated' );
            
          }
        }
        else{
          Log::info('No Update Available for student log' );
        }
        Log::info('RFIDS Log:'.implode(',', $user_insert).' at '.$date );
        
        Log::info('****** ****** ******* \n\n' );

        DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Update operation failed syncData(): ' . $e->getMessage().'on ' .$e->getLine());
        }
    }

    private function generateTableName($dateString="")
    {
        if($dateString == ""){
            $month = (int)now()->format('m');
            $year = now()->format('Y');
        }else{
            $date = new DateTime($dateString);
            $year =  (int) $date->format('Y');
            $month = (int) $date->format('m');
        }
        return "DeviceLogs_{$month}_{$year}";
    }
}
