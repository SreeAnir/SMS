<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    AccountingCategory,User,Status,Accounting,Batch,Fee,Notification,Event
};
use Carbon\Carbon ;
use Illuminate\Support\Facades\DB;
use App\Models\EpushServerModel;
class HomeController extends Controller
{
    //
    public function dashboard(){  
        // $epushData = EpushServerModel::all();
        // dd($epushData);
        try {
            $month =  Carbon::now()->format('F'); 
            $event_upcoming =[];
            $stats = DB::table('accountings')
            ->selectRaw('SUM(CASE WHEN acc_type = 1 THEN amount ELSE 0 END) AS total_income')
            ->selectRaw('SUM(CASE WHEN acc_type = 2 THEN amount ELSE 0 END) AS total_expense')
            ->selectRaw('SUM(CASE WHEN acc_type = 1 THEN amount ELSE -amount END) AS net_revenue')
            ->first();

            $total_income = $stats->total_income ;
            $total_expense = $stats->total_expense ;
            $net_revenue =(float) $stats->net_revenue;
              // Retrieve categories with the sum of related records from accountings table
              $incomeGroup = AccountingCategory::with('accountings' )
              ->select('category_label',  \DB::raw('SUM(accountings.amount) as total_amount'))
              ->leftJoin('accountings', 'accounting_categories.id', '=', 'accountings.category_id')
              ->where('accountings.acc_type',1)
              ->groupBy('accounting_categories.category_label', 'accounting_categories.id')
              ->has('accountings' )
              ->whereMonth('date',  Carbon::now()->month   )
              ->get();
                $month_income = $incomeGroup->sum('total_amount');
               $expenseGroup = AccountingCategory::with('accountings' )
              ->select('category_label',  \DB::raw('SUM(accountings.amount) as total_amount'))
              ->leftJoin('accountings', 'accounting_categories.id', '=', 'accountings.category_id')
              ->where('accountings.acc_type',2)
              ->groupBy('accounting_categories.category_label', 'accounting_categories.id')
              ->has('accountings')
              ->whereMonth('date', Carbon::now()->month  )
              ->get();
              $month_expense = $expenseGroup->sum('total_amount');

              $expense_data = [];
                foreach( $expenseGroup as $category){
                    // echo  $category->total_amount ."sjdh".$total_income ;
                    $perc=  (  (float) $category->total_amount  /(float) $total_income ) * 100; ;
                    $expense_data[] = ['label' => $category->category_label , 'data' => $perc ];
                }

                $income_data = [];
                foreach( $incomeGroup as $category){
                    // echo  $category->total_amount ."sjdh".$total_income ;
                    $perc=  (  (float) $category->total_amount  /(float) $total_income ) * 100; ;
                    $income_data[] = ['label' => $category->category_label , 'data' => $perc ];
                } 
                $monthly_income_data = $income_data ;
                $monthly_expense_data = $expense_data ;
                $students_count = User::StudentType()->where('status_id' , Status::STATUS_ACTIVE)->count();
                $new_application_count =  User::StudentType()->where('status_id' , Status::STATUS_PENDING)->count();
                $top_five_income = Accounting::select('category_id', \DB::raw('SUM(amount) as total_amount'))->with('category')
                ->groupBy('category_id')->IncomeData()
                ->orderByDesc('total_amount')
                ->take(5)
                ->get();
                $top_five_expense = Accounting::select('category_id', \DB::raw('SUM(amount) as total_amount'))->with('category')
                ->groupBy('category_id')
                ->orderByDesc('total_amount')->ExpenseData()
                ->take(5)
                ->get();
                 $counts['user'] = User::active()->AdminType()->count();
                 $counts['staff'] = User::active()->Staff()->count();
                 $counts['batch'] =  Batch::active()->count();
                 $counts['fee'] = Fee::Paid()->sum('amount');
                 $counts['event'] = Event::count();
                 $counts['notification'] = Notification::active()->count();
                 $event_upcoming = Event::whereBetween('event_date', [now(), now()->addDays(100)])
                 ->orderBy('event_date')
                 ->get();
            return view("admin.dashboard",compact('stats','event_upcoming' ,'counts','top_five_income','top_five_expense','monthly_income_data','monthly_expense_data' ,'month_income','month_expense','month' ,'net_revenue','new_application_count','students_count'));
        }catch (Exception $e) {  
            $response = ['status' => 'error', 'message' =>  $e->getMessage() ];
            return redirect()->back()->with($response);
        } 
     }
}
