<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory, Uuid;
    public $incrementing = false;
    protected $keyTape = 'uuid';

    protected $fillable = [
        'user_id',
        'name',
        'keterangan',
        'status'
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
