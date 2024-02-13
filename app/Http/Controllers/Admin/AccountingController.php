<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller ;
use Illuminate\Http\Request ;
use App\Models\Accounting ;
use App\Models\AccountingCategory ;
use App\Http\Requests\AccountingRequest;
use Illuminate\Support\Facades\DB;
use App\DataTables\AccountingDataTable;
use Validator;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
class AccountingController extends Controller
{
    public function __construct()
    {
         $this->authorizeResource(Accounting::class, 'accounting');
    }
    /**
     * Display a listing of the resource.
     */
     /**
     * Display a listing of the resource.
     */
    public function index(AccountingDataTable $dataTable)
    {
        try {
            $location_id = auth()->user()->location_id ;
            $categories = AccountingCategory::get();
            $stats = DB::table('accountings')
            ->when($location_id !=null , function ($query) use ($location_id) {
                return $query->where('accountings.location_id', $location_id);
                })
            ->selectRaw('SUM(CASE WHEN acc_type = 1 THEN amount ELSE 0 END) AS total_income')
            ->selectRaw('SUM(CASE WHEN acc_type = 2 THEN amount ELSE 0 END) AS total_expense')
            ->selectRaw('SUM(CASE WHEN acc_type = 1 THEN amount ELSE -amount END) AS net_revenue')
            ->first();

              // Retrieve categories with the sum of related records from accountings table
              $incomeGroup = AccountingCategory::select('category_label',  \DB::raw('SUM(accountings.amount) as total_amount'))
              ->leftJoin('accountings', 'accounting_categories.id', '=', 'accountings.category_id')
              ->when($location_id !=null , function ($query) use ($location_id) {
                return $query->where('accountings.location_id', $location_id);
                })
              ->where('accountings.acc_type',1)
              ->groupBy('accounting_categories.category_label', 'accounting_categories.id')
              ->has('accountings'  )
              ->get();
              $total_income = $stats->total_income ;
              $total_expense = $stats->total_expense ;

               $expenseGroup = AccountingCategory::select('category_label',  \DB::raw('SUM(accountings.amount) as total_amount'))
              ->leftJoin('accountings', 'accounting_categories.id', '=', 'accountings.category_id')
              ->when($location_id !=null , function ($query) use ($location_id) {
                return $query->where('accountings.location_id', $location_id);
                })
              ->where('accountings.acc_type',2)
              ->groupBy('accounting_categories.category_label', 'accounting_categories.id')
              ->has('accountings'  )
              ->get();
              $pie_data_expense = [];
                foreach( $expenseGroup as $category){
                    // echo  $category->total_amount ."sjdh".$total_income ;
                    $perc=  (  (float) $category->total_amount  /(float) $total_income ) * 100; ;
                    $pie_data_expense[] = ['label' => $category->category_label  .'('.number_format($perc,2).'%)', 'data' => $perc ];
                }

                $pie_data_income = [];
                foreach( $incomeGroup as $category){
                    // echo  $category->total_amount ."sjdh".$total_income ;
                    $perc=  (  (float) $category->total_amount  /(float) $total_income ) * 100; ;
                    $pie_data_income[] = ['label' => $category->category_label  .'('.number_format($perc,2).'%)',  'data' => $perc ];
                } 
            return $dataTable->render("admin.accounting.index",compact('categories','stats' ,'pie_data_income','pie_data_expense' ));
        }catch (Exception $e) {  
            $response = ['status' => 'error', 'message' =>  $e->getMessage() ];
            return redirect()->back()->with($response);
        } 
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories_income = AccountingCategory::where('category_type',1)->get();
        $categories_expense = AccountingCategory::where('category_type',2)->get();
        $location_id = auth()->user()->location_id ;
         $result = DB::table('accountings')
        ->selectRaw('SUM(CASE WHEN acc_type = 1 THEN amount ELSE 0 END) AS total_income')
        ->selectRaw('SUM(CASE WHEN acc_type = 2 THEN amount ELSE 0 END) AS total_expense')
        ->selectRaw('SUM(CASE WHEN acc_type = 1 THEN amount ELSE -amount END) AS net_revenue')
        ->when($location_id !=null , function ($query) use ($location_id) {
            return $query->where('accountings.location_id', $location_id);
            })
        ->first();

        $total_income =(float) $result->total_income;
        $total_expense = (float)$result->total_expense;
        $net_revenue =(float) $result->net_revenue;
        // $todays_telr = AccountingCategory::where('category_label', 'LIKE', "%Fee and Admission%")->get();
        // $todays_telr = Accounting::where('category_id',function( $query){
        //     return $query->where('category_id',  AccountingCategory::where('category_label', 'LIKE', "%Fee and Admission%")->first()->id  );
        // })->get()->sum();
        $feeAndAdmissionCategoryId = AccountingCategory::where('category_label', 'LIKE', "%Fee and Admission%")->first()->id;
        $today = Carbon::today();

        $todays_telr = Accounting::whereDate('date', $today)->where('category_id', $feeAndAdmissionCategoryId)->sum('amount');


        return view('admin.accounting.create',compact('todays_telr','categories_expense','categories_income','total_income','total_expense','net_revenue'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $income =  $request->income ;
            $expense =  $request->expense ; 
            $datarow = [];
            $date = now();
            $amount_check = 0;
            $location_id = auth()->user()->location_id ;
            foreach(  $income as $income_row){
                if($income_row['amount']  !="" &&  $income_row['amount']  > 0){
                    $amount_check = true;
                $datarow[] = 
                [ 'location_id' => $location_id ,'acc_type' => 1,'amount'=> $income_row['amount'] ,'remarks'=> $income_row['remarks'] , 'category_id' => $income_row['category_id'] , 'date' => $date ,'created_at' => now() ] ;
             }
            }
            foreach(  $expense as $expense_row){
                if($expense_row['amount']  !="" &&  $expense_row['amount']  > 0){
                    $amount_check = true;
                $datarow[] = 
                [ 'location_id' => $location_id  ,'acc_type' => 2 , 'amount'=> $expense_row['amount'] ,'remarks'=> $expense_row['remarks'] , 'category_id' => $expense_row['category_id'] , 'date' => $date ,'created_at' => now() ] ;
            }
            }

            if($amount_check == false ){
                $response = ['status' => 'error', 'message' => 'Failed to create income & expense!Please check the details entered'];
                return redirect()->back()->with($response);
            }
            if( count( $datarow )> 0){  
                DB::beginTransaction();
                Accounting::insert($datarow);  
                DB::commit();
                $response = ['status' => 'success', 'message' => 'Successfully Added the income and expense'];
                return redirect()->back()->with($response);
            }
        }catch (Exception $e) { dd($e);
            DB::rollback();
            return $e->getMessage(); 
        } 
    }

    /**
     * Display the specified resource.
     */
    public function show(Accounting $accounting)
    {
        
        try{
            
            $html = view('admin.accounting.partials.view', compact('accounting') )->render();

            return response()->json(['status' => "success", 'message' => "Accounting Details", "html" => $html ], 200);

        } catch (\Exception $e) { 
            return response()->json(['status' => "error", 'message' => $e->getMessage(), 'message_title' => "Failed to process"], 200);

        } 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Accounting $accounting)
    {
        try{
            $exp_categories = AccountingCategory::active()->where( 'category_type',2 )->get();
            $inc_categories = AccountingCategory::active()->where( 'category_type',1 )->get();

            $html = view('admin.accounting.partials.edit', compact('accounting','exp_categories','inc_categories') )->render();
            return response()->json(['status' => "success", 'message' => "Edit Accounting Details", "html" => $html ], 200);

        } catch (Exception $e) { 
            return response()->json(['status' => "error", 'message' => $e->getMessage(), 'message_title' => "Failed to process"], 200);

        } 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all() , [
                'category_id' => 'required|max:3',
                'amount' => [
                    'required',
                    'regex:/^\d+(\.\d{1,2})?$/',
                    'max:15',
                ],
                'location_id' => 'required',
                'remarks' => 'max:200',
                'acc_id' =>  'required',
                ]);

            if ($validator->fails())
            {
                $message = "Please enter valid details.";
                return response()->json(['status' => "fail", 'message' => $message, 'message_title' => "validation Fail!", 'debug' => $validator->errors() ], 200);
            }
            DB::beginTransaction();
            $id  = Crypt::decrypt( $request->acc_id);
        //    $accounting = Accounting::find( $id);
            $filteredData = $request->except(['acc_id','_token']);

            Accounting::where(["id" => $id ])->update($filteredData);

            DB::commit();
        //    $unwantedKeys = ['acc_id'];
        //    $requestData = $request->all();
        //    $filteredData = array_diff_key($requestData, array_flip($unwantedKeys));
        //    $updatedData = array_merge($filteredData, $accounting->toArray());
           
                    $response = ['status' => 'success', 'message' => 'Details updated successfully!'];
                    return response()->json($response, 200);

            
        }catch (Exception $e) {  
            $response = ['status' => 'error', 'message' =>  $e->getMessage() ];
            return $response;
        } 
        // return response()->json(['status' => "success", 'message' => "Details updated successfully"], 200);
        
    }

      /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccountingCategory  $catgory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Accounting $accounting)
    { 
        if ($accounting->delete()) {
            return [
                'status' => 'success', 'message' => __('Record deleted successfully!')];
        }
        return ['status' => 'error', 'message' => __('Failed to delete Record!')];
    }


    public function restore($id)
    {
        if ( Accounting::where('id', $id)->withTrashed()->restore()) {
            return [
                'status' => 'success', 'message' => __('Category restored successfully!')
            ];
        }
        return ['status' => 'error', 'message' => __('Failed to restore Category!')];
    }


    public function confirmDestroy( Accounting $accounting)
    {
        return [
            'status' => 'confirm',
            'message' => __('Are you sure to delete?!')
        ];
    }
}
