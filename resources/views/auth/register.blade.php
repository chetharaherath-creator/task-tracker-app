<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#F2EFE2] font-sans p-6 text-[#2D3536]">
        <div class="max-w-md w-full bg-white p-8 rounded-xl shadow-sm border border-[#B3C9D6]/30">
            
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold tracking-tight mb-2 text-[#2D3536]">Mint<span class="text-[#697C70]">.</span></h1>
                <h2 class="text-xl font-semibold mb-1">Create an account</h2>
                <p class="text-[#2D3536]/60 text-sm">Start your productivity journey today.</p>
            </div>

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-[#2D3536]/80 mb-1">Full name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                           class="w-full bg-white border border-[#B3C9D6]/40 rounded-lg shadow-sm focus:border-[#697C70] focus:ring-[#697C70] px-4 py-2.5 text-[#2D3536]" placeholder="John Doe">
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#2D3536]/80 mb-1">Email address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                           class="w-full bg-white border border-[#B3C9D6]/40 rounded-lg shadow-sm focus:border-[#697C70] focus:ring-[#697C70] px-4 py-2.5 text-[#2D3536]" placeholder="you@example.com">
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#2D3536]/80 mb-1">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           class="w-full bg-white border border-[#B3C9D6]/40 rounded-lg shadow-sm focus:border-[#697C70] focus:ring-[#697C70] px-4 py-2.5 text-[#2D3536]" placeholder="Create password">
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#2D3536]/80 mb-1">Confirm password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                           class="w-full bg-white border border-[#B3C9D6]/40 rounded-lg shadow-sm focus:border-[#697C70] focus:ring-[#697C70] px-4 py-2.5 text-[#2D3536]" placeholder="Confirm password">
                </div>

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="mt-4">
                        <label for="terms" class="flex items-center">
                            <input type="checkbox" name="terms" id="terms" required class="w-4 h-4 text-[#697C70] bg-white border-[#B3C9D6]/40 rounded focus:ring-[#697C70]">
                            <div class="ms-2 text-sm text-[#2D3536]/60">
                                I agree to the <a target="_blank" href="{{ route('terms.show') }}" class="text-[#697C70] hover:text-[#2D3536] transition">Terms of Service</a> and <a target="_blank" href="{{ route('policy.show') }}" class="text-[#697C70] hover:text-[#2D3536] transition">Privacy Policy</a>
                            </div>
                        </label>
                    </div>
                @endif

                <button type="submit" class="w-full py-2.5 mt-4 text-white bg-[#2D3536] rounded-lg hover:bg-[#1F2526] transition shadow-sm font-medium text-sm">
                    Sign up
                </button>
            </form>

            <div class="mt-8 text-center text-sm text-[#2D3536]/60">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-[#697C70] hover:text-[#2D3536] transition font-medium">Sign in</a>
            </div>
        </div>
    </div>
</x-guest-layout>
