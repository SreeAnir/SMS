<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Fee;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FeeExport;

class FeeExportController extends Controller
{
    public function export(Request $request)
    {
        // Get filtered parameters from the request
        // $filters = $request->only(['location_id', 'status_id','batch_id','kacha_id','class_count']);  
        // Apply filters to the query
        $fees = Fee::branchWise()->filterFromRequest()->with('user')->get();
        // Include relationships

        // Export to Excel using the UsersExport class
        return Excel::download(new FeeExport($fees), now().'fee.xlsx');
    }
}
