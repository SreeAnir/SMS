<?php 
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;
use Tests\TestCase;

class DataTableLoadTest2 extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Check if the environment is local
        if (app()->environment('local')) {

            $faker = Faker::create();
        $users = [1,2,3,4,5];
        for ($n = 0; $n < count($users ); $n++) {

        for ($i = 0; $i < 10000; $i++) {
            $logDate = $this->generateUniqueLogDate($users[$n],$i);

            DB::connection('epushserver')->table('devicelogs_3_2024')->insert([
                'DownloadDate' => $faker->date,
                'DeviceId' => 1,
                'UserId' => $users[$n] ,
                'LogDate' => $logDate,
                'Direction' => 'in',
                'AttDirection' => 'in',
                'C1' => 'in',
                'WorkCode' => 0,
            ]);
        }
        }
            // Set up configurations specific to the local environment
            // For example, seeding the database or mocking external services
            // Add your condition-specific setup logic here
    }
      
        // Perform your DataTables load test
        // Your test logic here
    }
    public function testExample()
    {
        // Your test logic goes here
        $this->assertTrue(true);
    }
       
        // Perform your DataTables load test
        // Your test logic here
    private function generateUniqueLogDate($user_id , $min)
    {
        $faker = Faker::create();
        $logDate = $faker->dateTimeBetween('2024-01-31', '2024-02-28')->format('Y-m-d H:m:s');
        while (DB::connection('epushserver')->table('devicelogs_2_2024')->where('UserId',$user_id )->where('LogDate', $logDate)->exists()) {
            $logDate =  $faker->dateTimeBetween('2024-02-10', '2024-02-28')->format('Y-m-d H:m:s');
        }

        return $logDate;
    }
}
