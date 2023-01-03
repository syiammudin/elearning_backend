<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory, Uuid;
    public $incrementing = false;
    protected $keyTape = 'uuid';

    protected $fillable = [
        'attachable_type',
        'attachable_id',
        'name',
        'path',
        'size',
        'mime',
        'type',
    ];

    protected $appends = ['url'];


    public function attachable()
    {
        return $this->morphTo();
    }

    public function getUrlAttribute()
    {
        return   env('APP_URL') . '/public/' . $this->path;
    }
}
