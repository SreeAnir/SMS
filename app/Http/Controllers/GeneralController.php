<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function loadBatches(Request $request)
    {
        if($request->location_id!=null){ 
            $batches = batchList($request->location_id);
        }else{
            $batches = batchList();
        }
        try{
            
            $html = view('admin.students.partials.batch-select',compact('batches'))->render();

            return response()->json(['status' => "success", 'message' =>"batch list", "html" => $html ], 200);

        } catch (Exception $e) { 
            return response()->json(['status' => "error", 'message' => $e->getMessage(), 'message_title' => "Failed to process"], 200);

        } 


    }
}
