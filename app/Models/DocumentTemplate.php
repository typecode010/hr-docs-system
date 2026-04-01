<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Document;

class DocumentTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'subject',
        'body',
        'placeholders',
    ];

    protected $casts = [
        'placeholders' => 'array',
    ];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
