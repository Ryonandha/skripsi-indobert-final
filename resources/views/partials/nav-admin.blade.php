<!-- Navigation for Admin -->
<div class="space-y-1" x-data="{ active: '{{ request()->route()->getName() }}' }">
    <a href="{{ route('admin.dashboard') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-calm-600 hover:bg-primary-50 hover:text-primary-700 transition-all duration-200 group
              {{ request()->routeIs('admin.dashboard') ? 'bg-primary-50 text-primary-700 font-medium' : '' }}">
        <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
        <span>Dashboard</span>
    </a>

    <a href="{{ route('admin.educations') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-calm-600 hover:bg-primary-50 hover:text-primary-700 transition-all duration-200 group
              {{ request()->routeIs('admin.educations*') ? 'bg-primary-50 text-primary-700 font-medium' : '' }}">
        <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
        <span>Artikel Edukasi</span>
    </a>

    <a href="{{ route('admin.users') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-calm-600 hover:bg-primary-50 hover:text-primary-700 transition-all duration-200 group
              {{ request()->routeIs('admin.users') ? 'bg-primary-50 text-primary-700 font-medium' : '' }}">
        <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        <span>Kelola Pengguna</span>
    </a>

    <hr class="my-3 border-calm-200">

    <a href="{{ route('profile.edit') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-calm-600 hover:bg-calm-100 hover:text-calm-900 transition-colors group">
        <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        <span>Profil & Pengaturan</span>
    </a>
</div>