<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Services\DataSyncService;
 
class EsslController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function fetchLog(DataSyncService $dataSyncService)
    {
        $date = '';
        if(request('date') !=""){
            $date = request('date') ;
        }
        $dataSyncService->syncData( date:  $date);
        echo "<b style='color:red;'> **** Data Sync completed !! **** </b>";
    }
    
}