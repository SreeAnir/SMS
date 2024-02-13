<?php
namespace App\Services;

use App\Models\{ Notification, User , NotificationUser,Status};

class NotificationService
{
    
    public function paymentDone(User $user, $feeLog)
    {
        $data = [];
        $data['user_id'] = $user->id ;
        if( $feeLog->status_id == Status::STATUS_PAID){
            $data['title'] = "Payment Recieved";
            $data['message'] = "Payment of ".priceFormatted( $feeLog->amount)." for fee has been recieved.";
        }else {
            $data['title'] = "Payment Failed";
            $data['message'] = "Your payment of ".priceFormatted( $feeLog->amount)." was not recieved.";
        }

        $this->logNotification( $data );
    }

    protected function logNotification( $data)
    {
        $notification = Notification::create([
            'title' =>  $data['title'],
            'message' => $data['message'],
            'notification_type' => 1,
            'notification_date' => now(),
            'status_id' => Status::STATUS_SENT,
        ]);
        NotificationUser::create(
            ['user_id' => $data['user_id'] , 'status_id' => Status::STATUS_SENT,'notification_id' =>  $notification->id ]
        );
       
    }
}
