<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatusRequest;
use App\Models\ApprovalStatus;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApprovalStatusUpdated;
use Illuminate\Support\Facades\DB;
use App\Mail\StudentApprovedEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StatusController extends Controller
{
    public function update(StatusRequest $request)
    {
        try{

       
        $model_name = $request->get('model');
        $model = $model_name::find($request->get('key'));
        if (!$model) {
            return ['status' => 'error', 'message' => __('Model not found!')];
        }
        $previous_status = $model->status_id ;
        if ($model->update(['status_id' => $request->get('value')])) { 
            if ($model_name == User::class &&  $previous_status == Status::STATUS_PENDING  && $model->status_id == Status::STATUS_ACTIVE) {
            $pw = "Test@123";
            $model->password  =   Hash::make( $pw ) ;
            if($model->ID_number ==""){
                $model->ID_number = 'kc' . str_pad($model->id, 4, '0', STR_PAD_LEFT);
                $model->user_name =  "kal-". strtoupper( Str::random(2). $model->status_id   ) ;
            }
            $model->save();
            Mail::to($model->email)->queue(new StudentApprovedEmail($model, $pw));
            
            //    DB::table('sessions')
            //    ->whereUserId($model->id)
            //     ->delete();
            //     foreach ($model->tokens as $token) {
            //         $token->revoke();
            //     }
            }
            return ['status' => 'success', 'message' => __('Status updated successfully.') , "status_text" => $model->status->status];
        }else{
        return ['status' => 'error', 'message' => __('Failed to update status!')];

        }
       } catch (\Exception $e) { 
                DB::rollback();
                $response = ['status' => 'error', 'message' =>  $e->getMessage() ];
                return redirect()->back()->with($response);
    } 

    }
    public function approval(StatusRequest $request)
    {
        $model_name = $request->get('model');
        $model = $model_name::find($request->get('key'));
        $reject_reason = $request->get('reject_reason');

        
        if (!$model) {
            return ['status' => 'error', 'message' => __('Model not found!')];
        }

        if ($model->update(['approval_status_id' => $request->get('value'), 'reject_reason' => $reject_reason])) {
            if ($model_name == User::class && $model->approval_status_id != ApprovalStatus::STATUS_TUTOR_APPROVED) {
                foreach ($model->tokens as $token) {
                    $token->revoke();
                }

            }
            $subject = __("Application Pending");
            if( $model->approval_status_id == ApprovalStatus::STATUS_TUTOR_APPROVED){
                $role_id = Role::where('name', Role::ROLE_TUTOR)->first()?->id;
                if ($role_id) {
                    $model->roles()->syncWithoutDetaching($role_id);
                }
                $subject = __("Application Accepted");
            }else if( $model->approval_status_id == ApprovalStatus::STATUS_TUTOR_REJECTED){
                $subject = __("Application Rejected");
            }

            Mail::to($model->email)->send(new ApprovalStatusUpdated($model,$subject));


            return ['status' => 'success', 'message' => __('Status updated successfully.')];
        }

        return ['status' => 'error', 'message' => __('Failed to pro!')];
    }


}
