<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoContent extends Model
{
    use HasFactory, Uuid;
    public $incrementing = false;
    protected $keyTape = 'uuid';

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'type',
        'type_value',
        'status',
        'kelas',
        'mime',
        'size',
        'path',
        'filename',
    ];

    protected $appends = [
        'rating_value', 'url', 'class'
    ];



    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }


    public function SearchBox()
    {
        return $this->morphOne(SearchBox::class, 'searcable');
    }

    public function Rating()
    {
        return $this->morphMany(Rating::class, 'ratingable');
    }

    public function History()
    {
        return $this->morphMany(History::class, 'historyable');
    }

    public function Attachment()
    {
        return $this->morphOne(Attachment::class, 'attachable');
    }

    public function Comment()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function GetRatingValueAttribute()
    {
        $value = Rating::where('ratingable_type', VideoContent::class)->where('ratingable_id', $this->id)->sum('value');
        $count = Rating::where('ratingable_type', VideoContent::class)->where('ratingable_id', $this->id)->count();
        if ($count == 0) {
            return 0;
        }
        return $value / $count;
    }

    public function getUrlAttribute()
    {
        return url($this->path);
    }
    public function getClassAttribute()
    {
        return VideoContent::class;
    }
}
