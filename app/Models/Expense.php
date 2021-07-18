<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'expense_category_id',
        'amount',
        'entry_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function expense_category()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('F d, Y H:m:s');
    }
}
