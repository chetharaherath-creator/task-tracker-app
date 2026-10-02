<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    <body class="font-sans antialiased text-[#2D3536]">
        <div class="flex h-screen bg-[#F2EFE2]">
            
            <!-- Sidebar -->
            <div class="w-64 bg-white p-6 flex flex-col justify-between border-r border-[#B3C9D6]/30 hidden md:flex">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight mb-8 text-[#2D3536]">Mint<span class="text-[#697C70]">.</span></h1>
                    <nav class="space-y-1">
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-[#98AA9D]/20 text-[#2D3536] font-semibold' : 'text-[#2D3536]/60 hover:text-[#2D3536] hover:bg-[#98AA9D]/10' }} flex items-center gap-3 px-3 py-2.5 rounded-lg transition text-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Dashboard
                        </a>
                        <a href="{{ route('tasks.create') }}" class="{{ request()->routeIs('tasks.create') ? 'bg-[#98AA9D]/20 text-[#2D3536] font-semibold' : 'text-[#2D3536]/60 hover:text-[#2D3536] hover:bg-[#98AA9D]/10' }} flex items-center gap-3 px-3 py-2.5 rounded-lg transition text-sm font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Add Task
                        </a>
                        <a href="{{ route('insights') }}" class="{{ request()->routeIs('insights') ? 'bg-[#98AA9D]/20 text-[#2D3536] font-semibold' : 'text-[#2D3536]/60 hover:text-[#2D3536] hover:bg-[#98AA9D]/10' }} flex items-center gap-3 px-3 py-2.5 rounded-lg transition text-sm font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            Insights
                        </a>
                        <a href="{{ route('profile.show') }}" class="text-[#2D3536]/60 hover:text-[#2D3536] hover:bg-[#98AA9D]/10 flex items-center gap-3 px-3 py-2.5 rounded-lg transition text-sm font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Profile
                        </a>
                    </nav>
                </div>
                
                <div class="flex items-center gap-3 pt-4 border-t border-[#B3C9D6]/30">
                    @if(auth()->user()->profile_photo_path)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" class="w-9 h-9 rounded-full object-cover shadow-sm border border-[#B3C9D6]/40">
                    @else
                        <div class="w-9 h-9 rounded-full bg-[#697C70] text-white flex items-center justify-center font-bold text-sm shadow-sm">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    @endif
                    <div class="leading-tight">
                        <p class="text-sm font-semibold text-[#2D3536]">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-[#2D3536]/60">Free Plan</p>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden relative">
                
                <!-- Topbar -->
                <header class="flex justify-between items-center p-8 pb-4">
                    <div class="flex-1"></div>
                    <div class="flex items-center gap-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-[#2D3536]/60 hover:text-[#2D3536] font-medium transition">Logout</button>
                        </form>
                    </div>
                </header>

                <main class="flex-1 overflow-y-auto p-4 sm:p-8 pt-2 pb-24 md:pb-8">
                    {{ $slot }}
                </main>
            </div>
            
            <!-- Mobile Bottom Nav -->
            <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-[#B3C9D6]/30 px-6 py-2 flex justify-between items-center z-50 pb-[calc(env(safe-area-inset-bottom)+8px)]">
                <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-1 transition group">
                    <div class="{{ request()->routeIs('dashboard') ? 'bg-[#98AA9D]/20 text-[#2D3536]' : 'text-[#2D3536]/40 group-hover:text-[#2D3536]' }} px-4 py-1.5 rounded-full transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </div>
                    <span class="text-[10px] {{ request()->routeIs('dashboard') ? 'font-bold text-[#2D3536]' : 'font-medium text-[#2D3536]/60' }}">Home</span>
                </a>
                <a href="{{ route('insights') }}" class="flex flex-col items-center gap-1 transition group">
                    <div class="{{ request()->routeIs('insights') ? 'bg-[#98AA9D]/20 text-[#2D3536]' : 'text-[#2D3536]/40 group-hover:text-[#2D3536]' }} px-4 py-1.5 rounded-full transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <span class="text-[10px] {{ request()->routeIs('insights') ? 'font-bold text-[#2D3536]' : 'font-medium text-[#2D3536]/60' }}">Insights</span>
                </a>
                <a href="{{ route('tasks.create') }}" class="flex flex-col items-center gap-1 -mt-6">
                    <div class="{{ request()->routeIs('tasks.create') ? 'bg-[#697C70] shadow-md' : 'bg-[#2D3536] shadow-lg' }} text-white p-3.5 rounded-full hover:bg-[#1F2526] transition transform hover:scale-105 border-4 border-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <span class="text-[10px] font-bold text-[#2D3536] -mt-1">Add</span>
                </a>
                <a href="{{ route('profile.show') }}" class="flex flex-col items-center gap-1 transition group">
                    <div class="{{ request()->routeIs('profile.show') ? 'bg-[#98AA9D]/20 text-[#2D3536]' : 'text-[#2D3536]/40 group-hover:text-[#2D3536]' }} px-4 py-1.5 rounded-full transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <span class="text-[10px] {{ request()->routeIs('profile.show') ? 'font-bold text-[#2D3536]' : 'font-medium text-[#2D3536]/60' }}">Profile</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="flex flex-col items-center gap-1 group">
                    @csrf
                    <button type="submit" class="flex flex-col items-center gap-1">
                        <div class="text-[#2D3536]/40 group-hover:text-red-500 px-4 py-1.5 rounded-full transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </div>
                        <span class="text-[10px] font-medium text-[#2D3536]/60 group-hover:text-red-500">Logout</span>
                    </button>
                </form>
            </div>
            
        </div>
        @livewireScripts
    </body>
</html>
