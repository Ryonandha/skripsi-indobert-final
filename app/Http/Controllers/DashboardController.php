<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return match ($request->user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'psikolog' => redirect()->route('psikolog.dashboard'),
            default => app(\App\Http\Controllers\Mahasiswa\ScreeningController::class)->dashboard($request),
        };
    }
}
