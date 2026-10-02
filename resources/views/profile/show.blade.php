<x-app-layout>
    <div class="max-w-5xl mx-auto font-sans text-[#2D3536] p-8">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight">My Profile</h1>
            <p class="text-[#2D3536]/60 mt-1">Manage your personal information and account security.</p>
        </div>

        @if (session('status'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-6 bg-[#697C70]/10 text-[#697C70] px-4 py-3 rounded-lg text-sm font-medium border border-[#697C70]/20" x-transition>
                @if(session('status') == 'profile-information-updated')
                    Success! Your profile has been updated.
                @elseif(session('status') == 'password-updated')
                    Success! Your password has been updated.
                @elseif(session('status') == 'profile-photo-deleted')
                    Success! Your profile photo has been removed.
                @else
                    Success! Action completed.
                @endif
            </div>
        @endif
        
        @if ($errors->any())
            <div class="mb-6 bg-red-50 text-red-600 px-4 py-3 rounded-lg text-sm font-medium border border-red-200">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="space-y-8">
            <!-- Profile Information Card -->
            <div class="bg-white rounded-xl shadow-sm border border-[#B3C9D6]/30 overflow-hidden">
                <form method="POST" action="{{ route('user-profile-information.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="p-8 md:flex gap-12">
                        <!-- Left side: Avatar -->
                        <div class="md:w-1/3 flex flex-col items-center text-center">
                            <div class="flex items-center gap-2 font-semibold mb-6 w-full justify-start text-lg">
                                <svg class="w-5 h-5 text-[#2D3536]/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Profile Information
                            </div>
                            
                            <div class="relative mb-4">
                                @if(auth()->user()->profile_photo_path)
                                    <img src="{{ auth()->user()->profile_photo_url }}" class="w-32 h-32 rounded-full object-cover border-4 border-[#F2EFE2]">
                                @else
                                    <div class="w-32 h-32 rounded-full bg-[#697C70] text-white flex items-center justify-center font-bold text-4xl border-4 border-[#F2EFE2]">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Custom File Upload Button -->
                            <div class="flex flex-col gap-2 w-full max-w-[200px]">
                                <div class="relative overflow-hidden inline-block w-full">
                                    <button type="button" class="w-full flex items-center justify-center gap-2 px-4 py-2 border border-[#B3C9D6]/50 rounded-lg text-sm font-medium hover:bg-[#F2EFE2] transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        Upload Photo
                                    </button>
                                    <input type="file" name="photo" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full" onchange="this.form.submit()">
                                </div>
                                
                                @if(auth()->user()->profile_photo_path)
                                    <button type="button" onclick="document.getElementById('delete-photo-form').submit()" class="w-full flex items-center justify-center gap-2 px-4 py-2 border border-red-200 text-red-600 rounded-lg text-sm font-medium hover:bg-red-50 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        Remove Photo
                                    </button>
                                @endif
                            </div>
                            <p class="text-xs text-[#2D3536]/40 mt-3">JPG, PNG or GIF. Max size 5 MB.</p>
                        </div>

                        <!-- Right side: Inputs -->
                        <div class="md:w-2/3 mt-8 md:mt-0 md:pt-14 space-y-5">
                            <div>
                                <label class="block text-sm font-medium text-[#2D3536] mb-1.5">Full Name</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 text-[#2D3536]/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <input type="text" name="name" value="{{ auth()->user()->name }}" required class="w-full pl-10 bg-white border border-[#B3C9D6]/40 rounded-lg shadow-sm focus:border-[#697C70] focus:ring-[#697C70] py-2.5 text-[#2D3536] text-sm">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-[#2D3536] mb-1.5">Email Address</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 text-[#2D3536]/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <input type="email" name="email" value="{{ auth()->user()->email }}" required class="w-full pl-10 bg-white border border-[#B3C9D6]/40 rounded-lg shadow-sm focus:border-[#697C70] focus:ring-[#697C70] py-2.5 text-[#2D3536] text-sm">
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </form>
            </div>

            <!-- Update Password Card -->
            <div class="bg-white rounded-xl shadow-sm border border-[#B3C9D6]/30 overflow-hidden">
                <form method="POST" action="{{ route('user-password.update') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="p-8 md:flex gap-12">
                        <!-- Left side: Text -->
                        <div class="md:w-1/3">
                            <div class="flex items-center gap-2 font-semibold mb-2 text-lg">
                                <svg class="w-5 h-5 text-[#2D3536]/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                Update Password
                            </div>
                            <p class="text-[#2D3536]/60 text-sm">Keep your account secure with a strong password.</p>
                        </div>

                        <!-- Right side: Inputs -->
                        <div class="md:w-2/3 space-y-5 mt-6 md:mt-0">
                            <div>
                                <label class="block text-sm font-medium text-[#2D3536] mb-1.5">Current Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 text-[#2D3536]/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    </div>
                                    <input type="password" name="current_password" required class="w-full pl-10 bg-white border border-[#B3C9D6]/40 rounded-lg shadow-sm focus:border-[#697C70] focus:ring-[#697C70] py-2.5 text-[#2D3536] text-sm" placeholder="Enter your current password">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-[#2D3536] mb-1.5">New Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 text-[#2D3536]/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    </div>
                                    <input type="password" name="password" required class="w-full pl-10 bg-white border border-[#B3C9D6]/40 rounded-lg shadow-sm focus:border-[#697C70] focus:ring-[#697C70] py-2.5 text-[#2D3536] text-sm" placeholder="Enter your new password">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-[#2D3536] mb-1.5">Confirm New Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 text-[#2D3536]/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    </div>
                                    <input type="password" name="password_confirmation" required class="w-full pl-10 bg-white border border-[#B3C9D6]/40 rounded-lg shadow-sm focus:border-[#697C70] focus:ring-[#697C70] py-2.5 text-[#2D3536] text-sm" placeholder="Confirm your new password">
                                </div>
                            </div>
                            
                            <div class="pt-2">
                                <button type="submit" class="px-5 py-2.5 text-sm text-white bg-[#2D3536] rounded-lg hover:bg-[#1F2526] transition shadow-sm font-medium">Update Password</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Hidden Form for Deleting Photo -->
    <form id="delete-photo-form" method="POST" action="{{ route('current-user-photo.destroy') }}" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</x-app-layout>
