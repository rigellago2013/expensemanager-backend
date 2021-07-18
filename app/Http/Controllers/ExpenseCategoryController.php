<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\ExpenseCategoryService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ExpenseCategoryController extends Controller
{
    protected $expenseCategoryService;

    public function __construct(ExpenseCategoryService $expenseCategoryService)
    {
        $this->expenseCategoryService = $expenseCategoryService;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expense_category = $this->expenseCategoryService->all();
        return $this->sendResponse($expense_category,'success');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'display_name' => $request['display_name'],
            'description' => $request['description']
        ];

        $validator =  Validator::make($data, [
            'display_name' => ['required', 'string', 'max:255'],    
            'description' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error creating user.',$validator->errors(), 400);
        }

        $expense_category = $this->expenseCategoryService->getModel()->updateOrCreate(['id' => $request->id],
        [
            'display_name' => $request->display_name,
            'description' => $request->description
        ]);

        if($expense_category) {
            return $this->sendResponse($expense_category, 'Category successfully created.');
        } else {
            return $this->sendError('Error creating category.', null, 400);
        }
  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $expense_category = $this->expenseCategoryService->find($request['id']);
        if($expense_category ) {
            $expense_category->delete();
            return $this->sendResponse('', 'Category sucessfully deleted.');   
        } else {
            return $this->sendError('Error deleting category.', null, 400);   
        }
    }

    /**
     * Get chart data
     */
    public function getExpenseCategoryChartdata()
    {
        return $expense_categories = $this->expenseCategoryService->getModel()->all();
    }
}
