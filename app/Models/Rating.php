<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory, Uuid;
    public $incrementing = false;
    protected $keyTape = 'uuid';
    
    protected $fillable = [
        'ratingable_type',
        'ratingable_id',
        'user_id',
        'value',
    ];

    public function ratingable()
    {
        return $this->morphTo();
    }
}
