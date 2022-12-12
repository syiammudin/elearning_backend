<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MasterQuiz extends Model
{
    use HasFactory, Uuid;
    public $incrementing = false;
    protected $keyTape = 'uuid';

    protected $fillable = [
        'user_id',
        'subject',
        'description',
        'max_duration',
        'max_attempt',
        'total_quizzes',
        'passing_grade',
    ];

    public function MasterQuizQuestion()
    {
        return $this->hasMany(MasterQuizQuestion::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
