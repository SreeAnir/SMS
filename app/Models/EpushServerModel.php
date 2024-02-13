<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use Illuminate\Support\Facades\DB;

class EpushServerModel extends Model
{
    protected $connection = 'epushserver';
    protected $dateString="";
    protected $table = 'DeviceLogs_1_2024';
    public function __construct(array $attributes = [] ,  $customDateOrString = null)
    {
        // dd($this->generateTableName());
        parent::__construct($attributes);

        // $this->dateString  = $customDateOrString ;
        // $this->setTable($this->generateTableName( ));

    }
    public function user()
    {
        return DB::connection('mysql')
            ->table('users')
            ->select(DB::raw('CONCAT(first_name," ",last_name) as full_name'))
            ->where('rfid', '=', $this->UserId)
            ->first();
    }
    public function scopeNew(Builder $query)
    {
        $last_fetched = DeviceLog::latest()->first();
        if( $last_fetched == null ){
            return $query ;
        }else{
            return $query->where('LogDate', '>', $last_fetched->log_date);
        }
    }
    public function scopeBranchWise(Builder $query)
    {
        if(auth()->user()->location_id !=null){
            return $query->filterByLocation( auth()->user()->location_id );
        }else{
            $user_ids =  DB::connection('mysql')
            ->table('users')
            ->select('rfid')
            ->whereNotNull('rfid')
            ->pluck('rfid');
            return $query->whereIn('UserId', $user_ids);
        }
        return $query;
    }

    
    public function scopeFilterByLocation(Builder $query, $location_id): Builder
    {
        // $nameToFilter = '%'.$text.'%';
        if( $location_id == ""){
            $location_id = auth()->user()->location_id ;
        }
        if($location_id !=null ){
            $user_ids =  DB::connection('mysql')
            ->table('users')
            ->select('rfid')
            ->whereNotNull('rfid')
            ->where('location_id', '=', $location_id)
            ->pluck('rfid');
            return $query->whereIn('UserId', $user_ids);
        }
        return $query;
    } 
    public function scopeFilterByBatch(Builder $query, $batch_id): Builder
    {
        return $query->whereHas('user', function ($query) use ($batch_id) {
            $query->whereIn('id' , function ($query) use ($batch_id) {
                $query->select('user_id')
                ->from('batch_students')
                ->where('batch_id', '=', $batch_id );
            });
         });
       
    } 
    public function scopeFilterFromRequest(Builder $query)
    {
       
        if (request()->filled('user_id')) {
            $query->where('UserId', request('user_id')  );
        }
        // if (request()->filled('year')) {
        //     $query->where('UserId', request('user_id')  );
        // }
        

    }
    // private function generateTableName( )
    // {
       
    //     if($this->dateString == ""){
    //         $month = (int)now()->format('m');
    //         $year = now()->format('Y');
    //     }else{  
    //         $date = new DateTime($this->dateString);
    //         $year =  (int) $date->format('Y');
    //         $month = (int) $date->format('m');
    //     }
    //     return "DeviceLogs_{$month}_{$year}";
    // }
    public static function tableName( $dateString)
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
