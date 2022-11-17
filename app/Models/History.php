<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory, Uuid;
    public $incrementing = false;
    protected $keyTape = 'uuid';
    protected $fillable = [
        'historyable_type',
        'historyable_id',
        'user_id',
        'remark',
        'status',
    ];

    public function historyable()
    {
        return $this->morphTo();
    }
}
