<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'logo', 'url'];

    public function employes(){
        return $this->hasMany(Employee::class, 'company_id');
    }

    public function admin(){
        return $this->belongsTo(Employee::class, 'company_id')->where('user_Type', 'company');
    }
}
