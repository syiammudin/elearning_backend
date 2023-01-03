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
        'mime',
        'name',
        'type',
        'size',
        'path'
    ];


    protected $casts = [
        'choices' => 'json'
    ];

    protected $appends = ['url'];


    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function MasterQuiz()
    {
        return $this->belongsTo(MasterQuiz::class);
    }

    public function getUrlAttribute()
    {
        return env('APP_URL') . '/public/' . $this->path;
    }
}
