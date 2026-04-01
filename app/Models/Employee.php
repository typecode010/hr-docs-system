<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Document;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_code',
        'first_name',
        'last_name',
        'email',
        'phone',
        'designation',
        'department',
        'date_of_joining',
        'status',
        'address',
    ];

    protected $casts = [
        'date_of_joining' => 'date',
    ];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
