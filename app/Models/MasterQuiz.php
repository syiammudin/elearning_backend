<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class MasterQuiz extends Model
{
    use HasFactory, Uuid, SoftDeletes;
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
        'kelas',
    ];

    protected $appends = [
        'status_quiz'
    ];

    protected $casts = [
        'kelas' => 'json'
    ];

    public function MasterQuizQuestion()
    {
        return $this->hasMany(MasterQuizQuestion::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusQuizAttribute()
    {
        if (Auth::user()) {
            $quiz = Exam::where('user_id', auth()->user()->id)->where('status', true)->where('master_quiz_id', $this->id)->count();
            return $quiz;
        }
    }

    public function SearchBox()
    {
        return $this->morphOne(SearchBox::class, 'searcable');
    }

    public function Attachment()
    {
        return $this->morphOne(Attachment::class, 'attachable');
    }
}
