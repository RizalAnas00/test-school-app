<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id',
        'academic_class_id',
        'nisn',
        'address',
        'phone_number',
        'age',
        'birth_date',
        'enrollment_date' 
    ];

    protected $casts = [
        'birth_date' => 'date',
        'enrollment_date' => 'date',
    ];

    public function academicClass()
    {
        return $this->belongsTo(AcademicClass::class);
    }

    public function parent()
    {
        return $this->belongsTo(Parents::class);
    }
}
