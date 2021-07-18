<?php
namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\User;

class ExpenseService extends BaseService
{   
    public function __construct(Request $request, Expense $expense)
    {
        parent::__construct($expense, $request);
    }

    public function getAll(){
        return $this->model->all();    
    }

    public function getUserExpenses($user)
    {
        return $this->model->where('user_id', $user->id)->get();
    }

    public function getModel()
    {
        return $this->model;
    }
}