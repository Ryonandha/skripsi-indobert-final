@extends('layouts.app')
@section('title', 'Kelola Pengguna')

@section('content')
<div class="animate-fade-in">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="font-display text-3xl font-bold text-calm-900">Kelola Pengguna</h1>
            <p class="text-calm-500 mt-1">
                @if($role === 'mahasiswa')
                    Ubah atau hapus akun mahasiswa. Akun baru terbentuk otomatis saat login Google kampus.
                @else
                    Tambah, ubah, dan hapus akun psikolog/konselor.
                @endif
            </p>
        </div>
        @if($role === 'psikolog')
            <a href="{{ route('admin.users.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-medium transition-colors shadow-soft">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Psikolog
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="mb-4 bg-primary-50 border border-primary-200 text-primary-800 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabs Role -->
    <div class="flex gap-2 mb-4">
        @foreach(['mahasiswa' => 'Mahasiswa', 'psikolog' => 'Psikolog'] as $r => $label)
            <a href="{{ route('admin.users', ['role' => $r]) }}"
               class="px-4 py-2 rounded-xl text-sm font-medium transition-colors {{ $role === $r ? 'bg-primary-600 text-white shadow-soft' : 'bg-white border border-calm-200 text-calm-600 hover:bg-calm-50' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    @if($role === 'mahasiswa')
        <div class="mb-4 bg-calm-50 border border-calm-200 text-calm-600 px-4 py-3 rounded-xl text-sm flex items-start gap-2">
            <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>Akun mahasiswa tidak dibuat manual oleh admin. Akun baru otomatis terbentuk saat mahasiswa pertama kali login dengan Google memakai email kampus (@student.stikomyos.ac.id). Gunakan tombol edit untuk melengkapi NIM/Prodi.</span>
        </div>
    @endif

    <!-- Search -->
    <form class="flex gap-2 mb-6">
        <input type="hidden" name="role" value="{{ $role }}">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, NIM, atau email..."
               class="border border-calm-200 rounded-xl px-4 py-2.5 w-full max-w-sm focus:ring-2 focus:ring-primary-500 outline-none bg-white text-sm">
        <button class="bg-calm-800 hover:bg-calm-900 text-white rounded-xl px-5 py-2.5 text-sm font-medium transition-colors">Cari</button>
    </form>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-card border border-calm-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-calm-50 text-left border-b border-calm-100">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-calm-700">Nama</th>
                        @if($role === 'mahasiswa')<th class="px-4 py-3 font-semibold text-calm-700">NIM</th><th class="px-4 py-3 font-semibold text-calm-700">Prodi</th>@endif
                        <th class="px-4 py-3 font-semibold text-calm-700">Email</th>
                        @if($role === 'mahasiswa')<th class="px-4 py-3 font-semibold text-calm-700">Skrining</th>@endif
                        <th class="px-4 py-3 font-semibold text-calm-700">Terdaftar</th>
                        <th class="px-4 py-3 font-semibold text-calm-700 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                        <tr class="border-t border-calm-100 hover:bg-calm-50/50 transition-colors">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center flex-shrink-0">
                                        <span class="text-primary-700 font-semibold text-xs">{{ strtoupper($u->name[0]) }}</span>
                                    </div>
                                    <span class="font-medium text-calm-900">{{ $u->name }}</span>
                                </div>
                            </td>
                            @if($role === 'mahasiswa')<td class="px-4 py-3 text-calm-600">{{ $u->nim ?? '—' }}</td><td class="px-4 py-3 text-calm-600">{{ $u->prodi ?? '—' }}</td>@endif
                            <td class="px-4 py-3 text-calm-600">{{ $u->email }}</td>
                            @if($role === 'mahasiswa')
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-calm-100 text-calm-700 text-xs font-semibold">{{ $u->screenings_count }} skrining</span>
                                </td>
                            @endif
                            <td class="px-4 py-3 text-calm-500 whitespace-nowrap">{{ $u->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.users.edit', $u) }}" title="Edit"
                                       class="p-2 rounded-lg text-calm-500 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $u) }}" method="POST"
                                          onsubmit="return confirm('Yakin hapus pengguna {{ $u->name }}? Tindakan ini tidak bisa dibatalkan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus"
                                                class="p-2 rounded-lg text-calm-500 hover:bg-danger-50 hover:text-danger-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-12 text-center">
                            <img src="{{ asset('images/data_tidak_ada.png') }}" alt="Data tidak ada" class="w-32 h-32 object-contain mx-auto mb-3" style="mix-blend-mode:multiply;">
                            <div class="text-calm-400 text-sm">Tidak ada data{{ request('q') ? ' untuk pencarian "' . request('q') . '"' : '' }}.</div>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $users->links() }}</div>
</div>
@endsection
