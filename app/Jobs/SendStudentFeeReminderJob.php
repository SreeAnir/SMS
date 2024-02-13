<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\NotificationUser;
use App\Models\Notification;
use App\Notifications\StudentFeeReminder;
use App\Models\Status;
use Carbon\Carbon;
use App\Models\FeeLog;
class SendStudentFeeReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $currentDate = Carbon::now();

        $tenDaysFromNow =  $currentDate->addDays(2)->toDateString();
    
        $upcoming_payments = FeeLog::whereDate('payment_due_date', $tenDaysFromNow)->where('status_id',Status::STATUS_UNPAID )->get();
        if($upcoming_payments->count() > 0 ){ 
            foreach ($upcoming_payments as $installment) {
                $user = $installment->fee->user ;
                $user->notify(new StudentFeeReminder( $installment));
            }
        }

        $currentDate = Carbon::today();

        // $tenDaysFromNow = $currentDate->addDays(2);
    
        $upcoming_payments = FeeLog::where('payment_due_date', $currentDate)->where('status_id',Status::STATUS_UNPAID )->get();
  
        if($upcoming_payments->count() > 0 ){ 
            foreach ($upcoming_payments as $installment) {
                $user = $installment->fee->user ;
                $user->notify(new StudentFeeReminder( $installment));
            }
        }
        
    }
}
