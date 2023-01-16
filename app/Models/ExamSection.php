<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSection extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;
    protected $keyTape = 'uuid';

    protected $fillable = [
        'exam_id',
        'user_id',
        'section',
        'start_section',
        'end_section',
    ];

    public function Exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
