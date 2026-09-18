<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounselingSchedule extends Model
{
    protected $fillable = [
        'psychologist_id', 'student_id', 'scheduled_date',
        'scheduled_time', 'location', 'notes', 'status',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
    ];

    public function psychologist()
    {
        return $this->belongsTo(User::class, 'psychologist_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
