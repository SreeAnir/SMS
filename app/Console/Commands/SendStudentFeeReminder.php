<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendStudentFeeReminderJob;
class SendStudentFeeReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:student-fee-reminder';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send student fee payment reminder';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        dispatch(new SendStudentFeeReminderJob());

        $this->info('Student Fee payment Reminder sent successfully.');

    }
}
