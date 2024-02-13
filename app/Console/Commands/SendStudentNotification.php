<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendStudentNotificationJob;
class SendStudentNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:student-notification';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send student notification';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        dispatch(new SendStudentNotificationJob());

        $this->info('Student notifications sent successfully.');

    }
}
