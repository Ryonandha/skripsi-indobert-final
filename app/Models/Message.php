<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'psychologist_id', 'student_id', 'screening_id', 'body', 'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function psychologist()
    {
        return $this->belongsTo(User::class, 'psychologist_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function screening()
    {
        return $this->belongsTo(Screening::class);
    }
}
