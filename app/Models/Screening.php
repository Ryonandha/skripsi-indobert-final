<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Screening extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'narrative', 'emotion_label', 'emotion_confidence',
        'emotion_probabilities', 'hars_score', 'hars_answers',
        'risk_level', 'recommendation', 'consent_followup', 'consented_at',
        'handled_by', 'handling_status', 'handling_notes',
        'crisis_flag', 'crisis_matched',
    ];

    protected $casts = [
        'emotion_probabilities' => 'array',
        'hars_answers' => 'array',
        'consent_followup' => 'boolean',
        'consented_at' => 'datetime',
        'crisis_flag' => 'boolean',
        'crisis_matched' => 'array',
    ];

    /**
     * Teks curhatan dienkripsi AES-256 saat tersimpan
     * (sesuai Bab II & Bab III skripsi: Kriptografi dan Keamanan Data).
     */
    public function setNarrativeAttribute($value): void
    {
        $this->attributes['narrative'] = encrypt($value);
    }

    public function getNarrativeAttribute($value): string
    {
        return decrypt($value);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function handler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by');
    }
}
