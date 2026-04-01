<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Document;

class DocumentLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'status',
        'message',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
