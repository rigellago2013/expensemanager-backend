<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Roles extends Model
{
    use HasFactory;

    protected $fillable = [
        'display_name',
        'description',
    ];
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('F d, Y H:m:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
