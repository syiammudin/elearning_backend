<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterQuizQuestion extends Model
{
    use HasFactory, Uuid;
    public $incrementing = false;
    protected $keyTape = 'uuid';

    protected $fillable = [
        'user_id',
        'master_quiz_id',
        'question',
        'choices',
        'correct_answer',
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function MasterQuiz()
    {
        return $this->belongsTo(MasterQuiz::class);
    }

    public static function booted()
    {
        static::creating(function ($model) {
            $model->user_id = auth()->id;
        });
    }
}
