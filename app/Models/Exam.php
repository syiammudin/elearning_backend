<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory, Uuid;
    public $incrementing = false;
    protected $keyTape = 'uuid';

    protected $fillable = [
        'master_quiz_id',
        'user_id',
        'max_duration',
        'max_attempt',
        'total_quizzes',
        'passing_grade',
        'score',
        'passed',
        'status',
        'cuntdown_time',
        'sisa_durasi',
        'start_time',
        'end_time',
    ];

    public function MasterQuiz()
    {
        return $this->belongsTo(MasterQuiz::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function ExamQuiz()
    {
        return $this->hasMany(ExamQuiz::class)->orderBy('nomor', 'asc');
    }

    public function ExamUser()
    {
        return $this->hasMany(ExamUser::class);
    }

    public function ExamSection()
    {
        return $this->hasMany(ExamSection::class);
    }
}
