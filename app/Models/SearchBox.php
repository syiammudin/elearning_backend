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

    public function searcable()
    {
        return $this->morphTo();
    }
}
