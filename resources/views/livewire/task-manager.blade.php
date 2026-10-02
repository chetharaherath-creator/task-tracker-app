@php
    try {
        // 1. Automatically detect user's location based on their Internet IP
        $locationResponse = \Illuminate\Support\Facades\Http::timeout(3)->get('http://ip-api.com/json/');
        
        if ($locationResponse->successful() && $locationResponse->json('status') === 'success') {
            $lat = $locationResponse->json('lat');
            $lon = $locationResponse->json('lon');
            $city = $locationResponse->json('city'); // Dynamically gets 'Ja-Ela', 'Kandy', etc.
            
            // 2. Fetch current weather for that exact location
            $weatherResponse = \Illuminate\Support\Facades\Http::timeout(3)
                ->get("https://api.open-meteo.com/v1/forecast?latitude={$lat}&longitude={$lon}&current_weather=true");
            
            if ($weatherResponse->successful()) {
                $weather = $weatherResponse->json('current_weather');
                $temp = round($weather['temperature']);
            } else {
                $weather = null;
            }
        } else {
            $weather = null;
            $city = 'Unknown';
        }
    } catch (\Exception $e) {
        $weather = null;
        $city = 'Unknown';
    }
@endphp

<div class="font-sans text-[#2D3536] max-w-5xl">
    
    <div class="mb-8 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 sm:gap-0">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-[#2D3536]">Good morning, {{ auth()->user()->name }}</h1>
            <p class="text-sm text-[#2D3536]/60 mt-1">Here is what's happening with your tasks today.</p>
        </div>
        <div class="flex flex-wrap sm:flex-nowrap items-center gap-3 sm:gap-4">
            <!-- Weather Widget -->
            @if(isset($weather) && $weather)
                <div class="flex items-center gap-2 px-4 py-2 bg-white border border-[#B3C9D6]/30 rounded-lg shadow-sm text-sm font-medium text-[#2D3536]">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path></svg>
                    <span>{{ $temp }}°C {{ $city }}</span>
                </div>
            @endif

            <a href="{{ route('tasks.create') }}" class="bg-[#2D3536] text-white px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-[#1F2526] transition shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New Task
            </a>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl p-5 border border-[#B3C9D6]/30 shadow-sm">
            <div class="flex items-center gap-3 mb-2 text-[#2D3536]/60">
                <svg class="w-5 h-5 text-[#B3C9D6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-xs font-medium uppercase tracking-wider">Total</span>
            </div>
            <span class="text-3xl font-semibold text-[#2D3536]">{{ collect($tasks)->count() }}</span>
        </div>
        <div class="bg-white rounded-xl p-5 border border-[#B3C9D6]/30 shadow-sm">
            <div class="flex items-center gap-3 mb-2 text-[#2D3536]/60">
                <svg class="w-5 h-5 text-[#98AA9D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-xs font-medium uppercase tracking-wider">In Progress</span>
            </div>
            <span class="text-3xl font-semibold text-[#2D3536]">{{ collect($tasks)->where('is_completed', false)->count() }}</span>
        </div>
        <div class="bg-white rounded-xl p-5 border border-[#B3C9D6]/30 shadow-sm">
            <div class="flex items-center gap-3 mb-2 text-[#2D3536]/60">
                <svg class="w-5 h-5 text-[#697C70]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span class="text-xs font-medium uppercase tracking-wider">Completed</span>
            </div>
            <span class="text-3xl font-semibold text-[#2D3536]">{{ collect($tasks)->where('is_completed', true)->count() }}</span>
        </div>
        <div class="bg-white rounded-xl p-5 border border-[#B3C9D6]/30 shadow-sm">
            <div class="flex items-center gap-3 mb-2 text-[#2D3536]/60">
                <svg class="w-5 h-5 text-[#2D3536]/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-xs font-medium uppercase tracking-wider">Overdue</span>
            </div>
            <span class="text-3xl font-semibold text-[#2D3536]">0</span>
        </div>
    </div>

    <!-- Main Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Task Lists -->
        <div class="md:col-span-2 space-y-6">
            
            @php
                $todayTasks = collect($tasks)->filter(function($task) {
                    return \Carbon\Carbon::parse($task->due_date)->isToday();
                });
            @endphp

            <!-- Today's Tasks -->
            <div class="bg-white rounded-xl shadow-sm border border-[#B3C9D6]/30 overflow-hidden">
                <div class="px-6 py-4 border-b border-[#B3C9D6]/20 bg-[#F2EFE2]/50">
                    <h3 class="font-semibold text-[#2D3536]">Today's Tasks</h3>
                </div>

                <div class="divide-y divide-[#B3C9D6]/10">
                    @if($todayTasks->isEmpty())
                        <div class="text-center py-8 text-[#2D3536]/50 text-sm">No tasks for today. Enjoy your day!</div>
                    @endif

                    @foreach($todayTasks as $task)
                        <div wire:key="today-task-{{ $task->id }}">
                            @include('components.task-item', ['task' => $task])
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- All Tasks -->
            <div class="bg-white rounded-xl shadow-sm border border-[#B3C9D6]/30 overflow-hidden">
                <div class="px-6 py-4 border-b border-[#B3C9D6]/20 bg-[#F2EFE2]/50">
                    <h3 class="font-semibold text-[#2D3536]">All Tasks</h3>
                </div>

                <div class="divide-y divide-[#B3C9D6]/10">
                    @if(collect($tasks)->isEmpty())
                        <div class="text-center py-12 text-[#2D3536]/50 text-sm">No tasks found. Click "New Task" to begin.</div>
                    @endif

                    @foreach($tasks as $task)
                        <div wire:key="all-task-{{ $task->id }}">
                            @include('components.task-item', ['task' => $task])
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Quick Notes -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-[#B3C9D6]/30 overflow-hidden">
                <div class="px-5 py-4 border-b border-[#B3C9D6]/20 bg-[#F2EFE2]/50 flex justify-between items-center">
                    <h4 class="font-semibold text-[#2D3536]">Quick Notes</h4>
                    @if (session()->has('note_saved'))
                        <span x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)" class="text-xs text-[#697C70] font-medium transition-all">Saved!</span>
                    @endif
                </div>
                <div class="p-0">
                    <textarea wire:model.defer="quick_note" rows="6" class="w-full bg-transparent border-0 focus:ring-0 p-5 text-sm text-[#2D3536] placeholder-[#2D3536]/40 resize-none" placeholder="Type any emergency notes, brain dumps, or reminders here..."></textarea>
                </div>
                <div class="px-5 py-3 border-t border-[#B3C9D6]/20 bg-[#F2EFE2]/30 flex justify-end">
                    <button wire:click="saveNote" class="px-4 py-2 text-xs text-white bg-[#2D3536] rounded-lg hover:bg-[#1F2526] transition font-medium shadow-sm flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Save Note
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
