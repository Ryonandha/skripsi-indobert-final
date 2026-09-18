<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

/**
 * NOTIFIKASI MAHASISWA: pesan/undangan dari psikolog.
 * Mahasiswa melihat daftar pesan, menandai sudah dibaca.
 */
class NotificationController extends Controller
{
    public function index()
    {
        $messages = Message::where('student_id', auth()->id())
            ->with('psychologist')
            ->latest()
            ->paginate(15);

        $unreadCount = Message::where('student_id', auth()->id())->where('is_read', false)->count();

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
            ->update(['is_read' => true]);

        return back()->with('success', 'Semua pesan ditandai sudah dibaca.');
    }
}
