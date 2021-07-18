<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class ExpenseCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'display_name',
        'description',
    ];

    protected $appends=[
        'chart_data'
    ];

    
    public function expenses(){
        return $this->hasMany(Expense::class, 'expense_category_id', 'id');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('F d, Y H:m:s');
    }

    public function getChartDataAttribute(){
        if(Auth::user()->role_id == Config::get('constants.role.administrator')){
            return $this->expenses->sum('amount');
        }else{
            return $this->expenses()->where('user_id', Auth::id())->sum('amount');
        }

    }
}
