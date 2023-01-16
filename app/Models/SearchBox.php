<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchBox extends Model
{
    use HasFactory, Uuid;
    public $incrementing = false;
    protected $keyTape = 'uuid';
    protected $fillable = [
        'searcable_type',
        'searcable_id',
        'descryption',
        'tag',
        'title',
        'url',
    ];

    protected $appends = ['modul'];

    public function searcable()
    {
        return $this->morphTo();
    }

    public function getModulAttribute()
    {
        if ($this->searcable_type == VideoContent::class) {
            return 'Materi';
        }
        if ($this->searcable_type == MasterQuiz::class) {
            return 'Quiz';
        }
        if ($this->searcable_type == Laboratorium::class) {
            return 'Laboratorium';
        }
    }
}
