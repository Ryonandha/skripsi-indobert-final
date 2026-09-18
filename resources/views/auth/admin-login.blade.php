@extends('layouts.app')
@section('title', 'Login Staf')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-xl shadow p-8">
    <h1 class="text-2xl font-bold mb-1 text-teal-800">Portal Staf</h1>
    <p class="text-sm text-slate-500 mb-6">Khusus admin teknis &amp; psikolog. Masuk dengan email + password.</p>

    @if(session('info'))
        <div class="mb-4 bg-teal-50 border border-teal-200 text-teal-800 rounded-lg px-4 py-3 text-sm leading-relaxed">{{ session('info') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500 outline-none">
            @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Password</label>
            <input type="password" name="password" required
                   class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500 outline-none">
        </div>
        <label class="flex items-center gap-2 text-sm text-slate-600">
            <input type="checkbox" name="remember" value="1" class="rounded"> Ingat saya
        </label>
        <button class="w-full bg-teal-700 hover:bg-teal-600 text-white rounded-lg py-2 font-semibold">
            Masuk sebagai Admin
        </button>
    </form>
</div>
@endsection
