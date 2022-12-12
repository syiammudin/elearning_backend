<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamUser extends Model
{
    use HasFactory, Uuid;
    public $incrementing = false;
    protected $keyTape = 'uuid';

    protected $fillable = [
        'exam_id',
        'user_id',
    ];

    public function Exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
