<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['profile', 'company'];

    public function company(){
        return $this->belongsTo(Company::class, 'company');
    }

    public function profile(){
        return $this->belongsTo(User::class, 'profile');
    }
}
