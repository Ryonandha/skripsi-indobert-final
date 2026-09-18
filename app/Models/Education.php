<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'educations';

    protected $fillable = ['title', 'slug', 'content', 'is_published'];

    protected $casts = ['is_published' => 'boolean'];
}
