<?php
namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Models\ExpenseCategory;

class ExpenseCategoryService extends BaseService
{
    public function __construct(Request $request, ExpenseCategory $expenseCategory)
    {
        parent::__construct($expenseCategory, $request);
    }

    /** 
     *  Get all expense.
     */
    public function getAll(){
        return $this->model->all();    
    }

    public function getModel()
    {
        return $this->model;
    }
}