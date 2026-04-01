<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'document_template_id',
        'generated_by',
        'status',
        'pdf_path',
        'generated_at',
        'sent_at',
        'error_message',
    ];

    protected $casts = [
        'generated_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function template()
    {
        return $this->belongsTo(DocumentTemplate::class, 'document_template_id');
    }

    public function logs()
    {
        return $this->hasMany(DocumentLog::class);
    }

    public function generator()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}
