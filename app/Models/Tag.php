<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['tag_name', 'slug'];
    protected $primaryKey = ['taggable_type', 'taggable_id'];

    public function movies()
    {
        return $this->morphedByMany(Movie::class, 'taggable');
    }
}
