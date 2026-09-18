<?php

namespace App\Mail;

use App\Models\Message;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Email notifikasi ketika psikolog mengirim pesan/undangan konseling
 * ke mahasiswa. Dikirim bersamaan dengan penyimpanan pesan in-app
 * di tabel `messages`.
 */
class PsychologistMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Message $message,
        public User $psychologist,
        public User $student,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pesan dari Konselor Kampus — ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.psychologist-message',
        );
    }
}
