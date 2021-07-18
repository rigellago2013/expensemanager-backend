<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use App\Http\Services\ExpenseService;

class ExpenseController extends Controller
{
    private $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = $this->getCurrentUser();
        if($user) {
            $expenses = $this->expenseService->getUserExpenses($user);
            return $this->sendResponse($expenses,'success');
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {      
        $user = $this->getCurrentUser();

        $validated = $request->validate([
            'expense_category_id' => 'required',
            'amount' => 'required',
            'entry_date' => 'required'
        ]);

        $expense = $this->expenseService->getModel()->updateOrCreate(['id' => $request->id],
        [
            'user_id' => $user->id,
            'expense_category_id' => $request->expense_category_id,
            'amount' => $request->amount,
            'entry_date' => $request->entry_date,
        ]);

        return $this->sendResponse($expense, 'Expense successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $expense = $this->expenseService->find($request->id);
        if($expense) {
            $expense->delete();
            return $this->sendResponse('', 'Expense sucessfully deleted.');   
        } else {
            return $this->sendError('Error deleting expense.', null, 400);   
        }
    }
}
