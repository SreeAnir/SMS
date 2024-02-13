<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentExport;

class StudentExportController extends Controller
{
    public function export(Request $request)
    {
        // Get filtered parameters from the request
        // $filters = $request->only(['location_id', 'status_id','batch_id','kacha_id','class_count']);  
        // Apply filters to the query
        $usersQuery = User::query()->filterFromRequest();
        // Include relationships
        $users = $usersQuery->with(['student','status','student.kachaStudents','location','student.batches'])->get();

        // Export to Excel using the UsersExport class
        return Excel::download(new StudentExport($users), 'users.xlsx');
    }
}
