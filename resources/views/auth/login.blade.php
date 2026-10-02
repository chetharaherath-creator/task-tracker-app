<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#F2EFE2] font-sans p-6 text-[#2D3536]">
        <div class="max-w-md w-full bg-white p-8 rounded-xl shadow-sm border border-[#B3C9D6]/30">
            
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold tracking-tight mb-2 text-[#2D3536]">Mint<span class="text-[#697C70]">.</span></h1>
                <h2 class="text-xl font-semibold mb-1">Welcome back</h2>
                <p class="text-[#2D3536]/60 text-sm">Please enter your details to sign in.</p>
            </div>

            <x-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-[#2D3536]/80 mb-1">Email address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                           class="w-full bg-white border border-[#B3C9D6]/40 rounded-lg shadow-sm focus:border-[#697C70] focus:ring-[#697C70] px-4 py-2.5 text-[#2D3536]" placeholder="you@example.com">
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#2D3536]/80 mb-1">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                           class="w-full bg-white border border-[#B3C9D6]/40 rounded-lg shadow-sm focus:border-[#697C70] focus:ring-[#697C70] px-4 py-2.5 text-[#2D3536]" placeholder="••••••••">
                </div>



                <button type="submit" class="w-full py-2.5 mt-2 text-white bg-[#2D3536] rounded-lg hover:bg-[#1F2526] transition shadow-sm font-medium text-sm">
                    Sign in
                </button>
            </form>

            <div class="mt-8 text-center text-sm text-[#2D3536]/60">
                Don't have an account? 
                <a href="{{ route('register') }}" class="text-[#697C70] hover:text-[#2D3536] transition font-medium">Sign up</a>
            </div>
        </div>
    </div>
</x-guest-layout>
