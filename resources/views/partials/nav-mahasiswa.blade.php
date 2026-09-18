<!-- Navigation for Mahasiswa -->
<div class="space-y-1" x-data="{ active: '{{ request()->route()->getName() }}' }">
    <a href="{{ route('dashboard') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-calm-600 hover:bg-primary-50 hover:text-primary-700 transition-all duration-200 group
              {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-primary-700 font-medium' : '' }}"
       :class="{ 'bg-primary-50 text-primary-700 font-medium': active === 'dashboard' }">
        <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
        <span>Dashboard</span>
    </a>

    <a href="{{ route('mahasiswa.screening.create') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-calm-600 hover:bg-primary-50 hover:text-primary-700 transition-all duration-200 group
              {{ request()->routeIs('mahasiswa.screening.create') ? 'bg-primary-50 text-primary-700 font-medium' : '' }}">
        <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
        <span>Skrining Baru</span>
    </a>

    <a href="{{ route('mahasiswa.history') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-calm-600 hover:bg-primary-50 hover:text-primary-700 transition-all duration-200 group
              {{ request()->routeIs('mahasiswa.history') ? 'bg-primary-50 text-primary-700 font-medium' : '' }}">
        <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0l1-1m-1 1l-1-1"/></svg>
        <span>Riwayat Skrining</span>
    </a>

    @php $unreadMessages = \App\Models\Message::where('student_id', auth()->id())->where('is_read', false)->count(); @endphp
    <a href="{{ route('mahasiswa.notifikasi.index') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-calm-600 hover:bg-primary-50 hover:text-primary-700 transition-all duration-200 group
              {{ request()->routeIs('mahasiswa.notifikasi.*') ? 'bg-primary-50 text-primary-700 font-medium' : '' }}">
        <span class="relative">
            <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            @if($unreadMessages > 0)
                <span class="absolute -top-1.5 -right-1.5 w-4 h-4 rounded-full bg-danger-500 text-white text-[10px] font-bold flex items-center justify-center">{{ $unreadMessages }}</span>
            @endif
        </span>
        <span>Notifikasi</span>
        @if($unreadMessages > 0)
            <span class="ml-auto px-2 py-0.5 rounded-full bg-primary-100 text-primary-700 text-xs font-semibold">{{ $unreadMessages }} baru</span>
        @endif
    </a>

    <a href="{{ route('profile.edit') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-calm-600 hover:bg-calm-100 hover:text-calm-900 transition-colors group">
        <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        <span>Profil & Pengaturan</span>
    </a>
</div>