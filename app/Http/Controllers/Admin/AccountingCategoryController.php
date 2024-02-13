<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\DB;
use App\Models\AccountingCategory;
use  App\DataTables\AccountingCategoryDataTable ;

class AccountingCategoryController extends Controller
{
    public function __construct()
    {
         $this->authorizeResource(AccountingCategory::class);
        //  'accounting_categories'
    }
    /**
     * Display a listing of the resource.
     */
    public function index(AccountingCategoryDataTable $dataTable)
    {
        try {  
            return $dataTable->render("admin.categories.index");
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
        return view('admin.categories.create');
    }

      /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        try {
            DB::beginTransaction();
            $categoryData = $request->getData();

            if ($category = AccountingCategory::create($categoryData)) {
                DB::commit();
                $response = ['status' => 'success', 'message' => 'Category created successfully!'];
                return redirect()->route('accounting-categories.show', $category)->with($response);
            }

            $response = ['status' => 'error', 'message' => 'Failed to create the Category!'];
            return redirect()->back()->with($response);

        } catch (Exception $e) {
            DB::rollback();
            $response = ['status' => 'error', 'message' => $e->getMessage()];
            return redirect()->back()->with($response);
        }
    }
   /**
     * Display the specified resource.
     */
    public function show(AccountingCategory $accountingCategory)
    { 
        return view('admin.categories.show', compact('accountingCategory'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AccountingCategory $accountingCategory)
    {
        return view('admin.categories.edit', compact('accountingCategory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function update(CategoryRequest $request, AccountingCategory $accountingCategory)
    {
        try {
            DB::beginTransaction();
            $categoryData = $request->getData(); 
            if ($save =$accountingCategory->update($categoryData)) {
                DB::commit();
                $response = ['status' => 'success', 'message' => 'Category updated successfully!'];
                return redirect()->route('accounting-categories.show', $accountingCategory)->with($response);
            }

            $response = ['status' => 'error', 'message' => 'Failed to update the Category!'];
            return redirect()->route('accounting-categories.show', $accountingCategory)->with($response);

            // return redirect()->back()->with($response);

        } catch (Exception $e) {
            DB::rollback();
            $response = ['status' => 'error', 'message' => $e->getMessage()];
            return redirect()->back()->with($response);
        }
    }
   
      /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccountingCategory  $catgory
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountingCategory $accountingCategory)
    { 
        if ($accountingCategory->delete()) {
            return [
                'status' => 'success', 'message' => __('Category deleted successfully!')];
        }
        return ['status' => 'error', 'message' => __('Failed to delete Category!')];
    }


    public function restore($id)
    {
        if ( AccountingCategory::where('id', $id)->withTrashed()->restore()) {
            return [
                'status' => 'success', 'message' => __('Category restored successfully!')
            ];
        }
        return ['status' => 'error', 'message' => __('Failed to restore Category!')];
    }


    public function confirmDestroy( AccountingCategory $accountingCategory)
    {
        return [
            'status' => 'confirm',
            'message' => __('Are you sure to delete :category_name ?!', ['category_name' => '<strong>'.$accountingCategory->name.'</strong>'])
        ];
    }
}
