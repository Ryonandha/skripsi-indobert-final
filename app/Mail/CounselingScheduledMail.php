<?php

namespace App\Mail;

use App\Models\CounselingSchedule;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Email notifikasi ketika psikolog menjadwalkan sesi konseling baru.
 * Berisi detail tanggal, waktu, lokasi, dan nama psikolog.
 */
class CounselingScheduledMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public CounselingSchedule $schedule,
        public User $psychologist,
        public User $student,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Jadwal Konseling Baru — ' . config('app.name'),
            replyTo: [
                new \Illuminate\Mail\Mailables\Address($this->psychologist->email, $this->psychologist->name)
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.counseling-scheduled',
        );
    }
}
