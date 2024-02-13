<?php

namespace App\Http\Controllers;
use Illuminate\Validation\ValidationException;

use App\Http\Requests\EmailValidationRequest;
use Exception;
use Illuminate\Http\Request;

class EmailChecksController extends Controller
{
    
    //email & user id
    public function emailCheckExists(EmailValidationRequest $request)
    {
        try {
        if( $request->email == null ){
            return response()->json(['status' => "error", 'message' => "Please provide a vali email", 'message_title' => "Email not valid"], 200);
        }else{
            return response()->json(['status' => "success", 'message' => "Valid Email", 'message_title' => "Email is valid"], 200);
        }

        }
         
        catch (Exception $e) { 
            return response()->json(['status' => "error", 'message' => $e->getMessage(), 'message_title' => "Email Invalid"], 200);

        } 

    }
}
