<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\{Status, EpushServerModel, Batch};
use Illuminate\Http\Request;
use App\DataTables\AttendanceDataTable;
use Exception;
use Illuminate\Support\Facades\{Schema, DB};
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

class AttendanceController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $routeName = Route::currentRouteName();
            $user_type = "staff";
            if ($routeName == 'student.attendance.index') {
                $user_type = "student";
            }

            $users = User::select(['id', 'first_name', 'last_name', 'ID_Number', 'rfid','user_type']);
            if( $user_type == "staff" ){
                $users  =   $users->staff() ;
            }else{
                $users  =   $users->studentType() ;
            }
            $customDateOrString =  null;
            if ($request->year) {
                $month = ($request->month ? $request->month : 2);
                $year =  $request->year;
                $year_month =  $request->year . " " . $request->month;
                $customDateOrString =  (string)$year . "-" . (string)$month . "-" . "01";
            } else {
                $month = (int)now()->format('m');
                $year = now()->format('Y');
                $year_month =  now()->format('M Y');
            }

            $batches = Batch::active()->get();

            $modelInstance = new EpushServerModel();
            $tableName =  EpushServerModel::tableName($customDateOrString);
            $attendance_data = [];
            if (Schema::connection('epushserver')->hasTable($tableName)) {
                $subQuery = $modelInstance->selectRaw('DISTINCT UserId, DATE(LogDate) as log_date')->from($tableName);
                $query =  $modelInstance->from(DB::raw("({$subQuery->toSql()}) as temp_table"))
                    ->mergeBindings($subQuery->getQuery())
                    ->select('UserId', DB::raw('GROUP_CONCAT(DAY(log_date)) AS ConcatenatedDays'))
                    ->groupBy(['UserId']);


                if ($request->user_id && $request->user_id != "") {
                    // $query = $query->where('UserId',$request->user_id);
                    $users = $users->where('rfid', $request->user_id);
                } elseif ($request->batch_id && $request->batch_id != "") {
                    $users = $users->FilterBatchAllStatus($request->batch_id);
                    // $query = $query->FilterByBatch($request->batch_id);
                } elseif ($request->location_id && $request->location_id != "") {
                    $users = $users->FilterByLocation($request->location_id);
                    // $query = $query->FilterByLocation($request->location_id);
                } else {
                    $query = $query->BranchWise();
                }
                $users = $users->get();
                $query = $query->whereIn('UserId', $users->pluck('rfid'));
                $attendance_data = $query->pluck('ConcatenatedDays', 'UserId');
            } else {
                $users = $users->get();
                $attendance_data = [];
            }
            $searched_location = "";
            $numberOfDaysInMonth = Carbon::createFromDate(null,  $month, 1)->daysInMonth;
            $days = range(1, $numberOfDaysInMonth);
            if ($request->ajax()) {

                $htm = view("admin.attendance.paper-view", compact('days',  'users', 'attendance_data', 'year_month', 'searched_location', 'batches'))->render();
                return response()->json(['status' => "success", 'message' => "Attendance Filter", "html" => $htm], 200);
                // return view("admin.attendance.paper-view",compact('days',  'users','attendance_data','year_month','searched_location','batches'));
            } else {
                $users =  User::select(['id', 'first_name', 'last_name', 'ID_Number', 'rfid','user_type']);
                if( $user_type == "staff" ){
                    $users  =   $users->staff() ;
                }else{
                    $users  =   $users->studentType() ;
                }
                $users  = $users->get();
                return view("admin.attendance.index", compact( 'user_type','days', 'users', 'attendance_data', 'year_month', 'searched_location', 'batches'));
            }
        } catch (Exception $e) {
            $response = ['status' => 'error', 'message' =>  $e->getMessage()];
            if ($request->ajax()) {
                return response()->json(['status' => "success", 'message' => "Attendance Filter", "html" => "Reload the page" . $e->getMessage() . $e->getLine()], 200);
            }
            dd($e->getMessage());
            return redirect()->back()->with($response);
        }
    }
    public function index1(AttendanceDataTable $dataTable)
    {
        try {
            $paymet_statuses = Status::paymentStatuslist();
            $users = User::select(['id', 'first_name', 'last_name', 'ID_Number', 'rfid'])->studentType()->get();

            return $dataTable->render("admin.attendance.index", compact('paymet_statuses', 'users'));
        } catch (Exception $e) {
            $response = ['status' => 'error', 'message' =>  $e->getMessage()];
            return redirect()->back()->with($response);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
