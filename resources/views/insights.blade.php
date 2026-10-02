<x-app-layout>
    <div class="max-w-5xl mx-auto font-sans text-[#2D3536]">
        <div class="mb-8">
            <h1 class="text-2xl font-bold tracking-tight">Your Insights</h1>
            <p class="text-sm text-[#2D3536]/60 mt-1">Track your productivity across different categories.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($stats as $stat)
                <div class="bg-white rounded-xl p-6 border border-[#B3C9D6]/30 shadow-sm transition hover:shadow-md">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-lg">{{ $stat['name'] }}</h3>
                        <span class="text-sm font-medium text-[#697C70]">{{ $stat['percentage'] }}%</span>
                    </div>
                    
                    <!-- Progress Bar Background -->
                    <div class="w-full bg-[#F2EFE2] rounded-full h-2.5 mb-4 overflow-hidden">
                        <!-- Progress Bar Fill -->
                        <div class="bg-[#697C70] h-2.5 rounded-full transition-all duration-1000 ease-out" style="width: {{ $stat['percentage'] }}%"></div>
                    </div>
                    
                    <p class="text-xs text-[#2D3536]/60">
                        {{ $stat['completed'] }} of {{ $stat['total'] }} tasks completed
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
