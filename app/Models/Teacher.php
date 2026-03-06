<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'subject',
        'address',
        'phone_number',
        'birth_date',
    ];

    public function academicClasses()
    {
        return $this->hasMany(AcademicClass::class);
    }
}
