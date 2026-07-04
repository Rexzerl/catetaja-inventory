<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Borrowing extends Model
{
    protected $fillable = ['user_id','employee_name', 'borrow_date', 'return_date', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function Details()
    {
        return $this->hasMany(BorrowingDetail::class);
    }
}
