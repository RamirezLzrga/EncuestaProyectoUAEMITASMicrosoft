<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Survey extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'surveys';

    protected $fillable = [
        'title',
        'description',
        'header_image',
        'year',
        'start_date',
        'end_date',
        'is_active',
        'settings',
        'questions',
        'user_id',
        'approval_status',
        'approval_comment',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'settings' => 'array',
        'questions' => 'array',
        'approved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function responses()
    {
        return $this->hasMany(SurveyResponse::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
