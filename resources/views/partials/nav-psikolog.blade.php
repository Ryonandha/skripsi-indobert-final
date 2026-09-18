<!-- Navigation for Psikolog/Konselor -->
<div class="space-y-1" x-data="{ active: '{{ request()->route()->getName() }}' }">
    <a href="{{ route('psikolog.dashboard') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-calm-600 hover:bg-primary-50 hover:text-primary-700 transition-all duration-200 group
              {{ request()->routeIs('psikolog.dashboard') ? 'bg-primary-50 text-primary-700 font-medium' : '' }}">
        <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
        <span>Dashboard Konseling</span>
    </a>

    <a href="{{ route('psikolog.patients') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-calm-600 hover:bg-primary-50 hover:text-primary-700 transition-all duration-200 group
              {{ request()->routeIs('psikolog.patients') ? 'bg-primary-50 text-primary-700 font-medium' : '' }}">
        <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        <span>Daftar Mahasiswa</span>
    </a>

    <a href="{{ route('psikolog.schedule') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-calm-600 hover:bg-primary-50 hover:text-primary-700 transition-all duration-200 group
              {{ request()->routeIs('psikolog.schedule') ? 'bg-primary-50 text-primary-700 font-medium' : '' }}">
        <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        <span>Jadwal Konseling</span>
    </a>

    <a href="{{ route('psikolog.notes') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-calm-600 hover:bg-primary-50 hover:text-primary-700 transition-all duration-200 group
              {{ request()->routeIs('psikolog.notes') ? 'bg-primary-50 text-primary-700 font-medium' : '' }}">
        <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        <span>Catatan Progres</span>
    </a>

    <hr class="my-3 border-calm-200">

    <a href="{{ route('profile.edit') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-calm-600 hover:bg-calm-100 hover:text-calm-900 transition-colors group">
        <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        <span>Profil & Pengaturan</span>
    </a>
</div>