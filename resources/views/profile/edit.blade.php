@extends('layouts.app')
@section('title', 'Profil & Pengaturan')

@section('content')
<div class="max-w-2xl mx-auto animate-fade-in">
    <div class="mb-8">
        <h1 class="font-display text-3xl font-bold text-calm-900">Profil & Pengaturan</h1>
        <p class="text-calm-500 mt-1">Kelola informasi akun dan keamanan Anda</p>
    </div>

    <div class="bg-white rounded-2xl shadow-card border border-calm-100 overflow-hidden">
        <!-- Tab Navigation -->
        <div class="border-b border-calm-100">
            <nav class="flex -mb-px" aria-label="Tab navigasi profil">
                @foreach([
                    'informasi' => 'Informasi Akun',
                    'keamanan' => 'Keamanan',
                    'notifikasi' => 'Notifikasi',
                ] as $key => $label)
                    <a href="#{{ $key }}"
                       class="tab-link px-5 py-3 border-b-2 font-medium text-sm transition-colors
                              {{ $loop->first ? 'border-primary-600 text-primary-600' : 'border-transparent text-calm-500 hover:text-calm-700' }}"
                       data-tab="{{ $key }}">{{ $label }}</a>
                @endforeach
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6 space-y-8">
            {{-- TAB 1: Informasi Akun --}}
            <div id="informasi" class="tab-content">
                <h2 class="font-display text-lg font-semibold text-calm-900 mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Informasi Pribadi
                </h2>

                <form method="POST" action="{{ route('profile.update') }}" class="space-y-5" enctype="multipart/form-data">
                    @csrf

                    @if(auth()->user()->isMahasiswa())
                        <div>
                            <label class="block text-sm font-medium text-calm-700 mb-1">NIM <span class="text-danger-500">*</span></label>
                            <input type="text" name="nim" value="{{ old('nim', auth()->user()->nim) }}" required maxlength="7"
                                   class="w-full px-4 py-2.5 border border-calm-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none">
                            @error('nim') <p class="text-danger-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-calm-700 mb-1">Program Studi <span class="text-danger-500">*</span></label>
                            <select name="prodi" required
                                    class="w-full px-4 py-2.5 border border-calm-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none">
                                <option value="">Pilih Program Studi</option>
                                <option value="Informatika" {{ old('prodi', auth()->user()->prodi) === 'Informatika' ? 'selected' : '' }}>Informatika</option>
                                <option value="Sistem Informasi" {{ old('prodi', auth()->user()->prodi) === 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                                <option value="Teknik Informatika" {{ old('prodi', auth()->user()->prodi) === 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                                <option value="Manajemen Informatika" {{ old('prodi', auth()->user()->prodi) === 'Manajemen Informatika' ? 'selected' : '' }}>Manajemen Informatika</option>
                                <option value="Lainnya" {{ old('prodi', auth()->user()->prodi) === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('prodi') <p class="text-danger-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-calm-700 mb-1">Nama Lengkap <span class="text-danger-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                               class="w-full px-4 py-2.5 border border-calm-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none">
                        @error('name') <p class="text-danger-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-calm-700 mb-1">Email</label>
                        <input type="email" value="{{ auth()->user()->email }}" readonly
                               class="w-full px-4 py-2.5 border border-calm-200 rounded-xl bg-calm-50 text-calm-500 outline-none cursor-not-allowed">
                        <p class="text-xs text-calm-500 mt-1">Email tidak dapat diubah (digunakan sebagai identitas login).</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-calm-700 mb-1">Nomor HP</label>
                        <input type="tel" name="phone" value="{{ old('phone', auth()->user()->phone) }}"
                               class="w-full px-4 py-2.5 border border-calm-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none"
                               placeholder="08xxxxxxxxxx">
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-medium transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            {{-- TAB 2: Keamanan --}}
            <div id="keamanan" class="tab-content hidden">
                <h2 class="font-display text-lg font-semibold text-calm-900 mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Ubah Password
                </h2>

                <form method="POST" action="{{ route('profile.password') }}" class="space-y-5 max-w-md">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-calm-700 mb-1">Password Saat Ini <span class="text-danger-500">*</span></label>
                        <input type="password" name="current_password" required
                               class="w-full px-4 py-2.5 border border-calm-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none">
                        @error('current_password') <p class="text-danger-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-calm-700 mb-1">Password Baru <span class="text-danger-500">*</span></label>
                        <input type="password" name="password" required
                               class="w-full px-4 py-2.5 border border-calm-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none">
                        @error('password') <p class="text-danger-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-calm-700 mb-1">Konfirmasi Password Baru <span class="text-danger-500">*</span></label>
                        <input type="password" name="password_confirmation" required
                               class="w-full px-4 py-2.5 border border-calm-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none">
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-medium transition-colors">
                            Ubah Password
                        </button>
                    </div>
                </form>

                <hr class="my-6 border-calm-200">

                <!-- Sessions/Devices (placeholder) -->
                <h3 class="font-medium text-calm-900 mb-3">Sesi Aktif</h3>
                <div class="bg-calm-50 rounded-xl p-5">
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <p class="font-medium text-calm-900">Sesi Ini</p>
                                <p class="text-xs text-calm-500">Chrome di Windows • Aktif sekarang</p>
                            </div>
                        </div>
                        <span class="px-2 py-1 bg-primary-50 text-primary-700 text-xs font-semibold rounded-full">Aktif</span>
                    </div>
                    <p class="text-xs text-calm-500 mt-3">Fitur kelola sesi lain akan segera hadir.</p>
                </div>
            </div>

            {{-- TAB 3: Notifikasi --}}
            <div id="notifikasi" class="tab-content hidden">
                <h2 class="font-display text-lg font-semibold text-calm-900 mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    Preferensi Notifikasi
                </h2>

                <p class="text-calm-500 text-sm mb-6">Atur jenis notifikasi yang ingin Anda terima.</p>

                <div class="space-y-4">
                    @foreach([
                        'screening_reminder' => ['title' => 'Pengingat Skrining Mingguan', 'desc' => 'Dapatkan pengingat untuk melakukan skrining berkala', 'default' => true],
                        'high_risk_alert' => ['title' => 'Peringatan Risiko Tinggi', 'desc' => 'Notifikasi jika hasil skrining menunjukkan risiko tinggi', 'default' => true],
                        'education_new' => ['title' => 'Artikel Edukasi Baru', 'desc' => 'Dapatkan info saat ada artikel kesehatan mental baru', 'default' => true],
                        'counseling_schedule' => ['title' => 'Jadwal Konseling', 'desc' => 'Pengingat jadwal sesi konseling dengan psikolog', 'default' => true],
                    ] as $key => $notif)
                        <div class="flex items-center justify-between p-4 bg-calm-50 rounded-xl">
                            <div class="flex-1">
                                <p class="font-medium text-calm-900">{{ $notif['title'] }}</p>
                                <p class="text-sm text-calm-500">{{ $notif['desc'] }}</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" {{ $notif['default'] ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-calm-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-calm-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Simple tab switching
    document.addEventListener('DOMContentLoaded', () => {
        const tabs = document.querySelectorAll('.tab-link');
        const contents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', (e) => {
                e.preventDefault();
                const target = tab.dataset.tab;

                // Update active tab
                tabs.forEach(t => {
                    t.classList.remove('border-primary-600', 'text-primary-600');
                    t.classList.add('border-transparent', 'text-calm-500');
                });
                tab.classList.remove('border-transparent', 'text-calm-500');
                tab.classList.add('border-primary-600', 'text-primary-600');

                // Show target content
                contents.forEach(c => {
                    c.classList.add('hidden');
                });
                document.getElementById(target).classList.remove('hidden');
            });
        });
    });
</script>
@endpush