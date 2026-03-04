<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SurveyTemplate extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'survey_templates';

    protected $fillable = [
        'name',
        'category',
        'is_mandatory',
        'structure',
        'created_by',
    ];

    protected $casts = [
        'is_mandatory' => 'boolean',
        'structure' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

