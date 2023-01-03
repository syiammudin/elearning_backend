<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamQuiz extends Model
{
    use HasFactory, Uuid;
    public $incrementing = false;
    protected $keyTape = 'uuid';

    protected $fillable = [
        'exam_id',
        'user_id',
        'nomor',
        'choices',
        'question',
        'correct_answer',
        'user_answer',
        'status',
        'path'
    ];

    protected $casts = [
        'choices' => 'json'
    ];

    protected $appends = [
        'url'
    ];

    public function Exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public static function booted()
    {
        static::creating(function ($model) {
            $model->user_id = auth()->user()->id;
        });
    }

    public function getUrlAttribute()
    {
        return env('APP_URL') . '/public/' . $this->path;
    }
}
