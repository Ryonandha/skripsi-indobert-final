<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * NOTIFIKASI MAHASISWA: pesan/undangan dari psikolog.
 * Mahasiswa melihat daftar pesan, menandai sudah dibaca, dan bisa membalas.
 */
class NotificationController extends Controller
{
    public function index()
    {
        // Load semua pesan terkait mahasiswa ini (diterima maupun balasan)
        $messages = Message::where('student_id', auth()->id())
            ->with('psychologist')
            ->latest()
            ->paginate(15);

        $unreadCount = Message::where('student_id', auth()->id())
            ->where('is_read', false)
            ->where('is_from_student', false) // hanya pesan masuk yang belum dibaca
            ->count();

        return view('mahasiswa.notifikasi', compact('messages', 'unreadCount'));
    }

    public function markRead(Message $message)
    {
        abort_unless($message->student_id === auth()->id(), 403);

        $message->update(['is_read' => true]);

        return back();
    }

    public function markAllRead()
    {
        Message::where('student_id', auth()->id())
            ->where('is_read', false)
            ->where('is_from_student', false)
            ->update(['is_read' => true]);

        return back()->with('success', 'Semua pesan ditandai sudah dibaca.');
    }

    /**
     * Mahasiswa membalas pesan dari psikolog.
     * Reply dikirimkan ke psikolog yang sama dengan pesan asli.
     */
    public function reply(Message $message, Request $request)
    {
        abort_unless($message->student_id === auth()->id(), 403);

        $request->validate([
            'body' => ['required', 'string', 'min:3', 'max:500'],
        ]);

        // Buat pesan balasan (is_from_student = true)
        Message::create([
            'psychologist_id'  => $message->psychologist_id,
            'student_id'       => auth()->id(),
            'screening_id'     => $message->screening_id,
            'body'             => $request->body,
            'is_read'          => false, // belum dibaca oleh psikolog
            'is_from_student'  => true,
        ]);

        // Tandai pesan asli sebagai sudah dibaca
        $message->update(['is_read' => true]);

        return back()->with('success', 'Balasanmu sudah terkirim ke psikolog.');
    }
}
