@php
    $catColor = match($task->category) {
        'Work' => 'border-l-[4px] border-blue-400 bg-blue-50/10',
        'Health' => 'border-l-[4px] border-[#697C70] bg-[#697C70]/5',
        'Study' => 'border-l-[4px] border-purple-400 bg-purple-50/10',
        default => 'border-l-[4px] border-amber-400 bg-amber-50/10',
    };
    
    $badgeColor = match($task->category) {
        'Work' => 'bg-blue-100 text-blue-700',
        'Health' => 'bg-[#697C70]/10 text-[#697C70]',
        'Study' => 'bg-purple-100 text-purple-700',
        default => 'bg-amber-100 text-amber-700',
    };
    
    $catIcon = match($task->category) {
        'Work' => '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>',
        'Health' => '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>',
        'Study' => '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>',
        default => '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>',
    };
@endphp

<div class="flex flex-col sm:flex-row sm:items-center justify-between p-6 gap-4 sm:gap-0 group transition {{ $task->is_completed ? 'opacity-50' : '' }} {{ $catColor }} hover:brightness-95">
    <div class="flex items-start gap-4">
        <!-- Checkbox Button -->
        <button wire:click="toggleComplete({{ $task->id }})" class="mt-0.5 flex-shrink-0 w-5 h-5 rounded border border-[#B3C9D6] flex items-center justify-center transition-colors {{ $task->is_completed ? 'bg-[#697C70] border-[#697C70]' : 'bg-white hover:border-[#697C70]' }}">
            @if($task->is_completed)
                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
            @endif
        </button>
        <div>
            <h4 class="font-medium text-sm {{ $task->is_completed ? 'line-through text-[#2D3536]/40' : 'text-[#2D3536]' }}">{{ $task->title }}</h4>
            <div class="flex flex-col gap-1 mt-1">
                <span class="text-xs text-[#2D3536]/60 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-[#B3C9D6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                </span>
                @if($task->description)
                    <p class="text-xs text-[#2D3536]/40">{{ Str::limit($task->description, 50) }}</p>
                @endif
                
                @if($task->attachment_path)
                    <div x-data="{ showModal: false }" class="inline-block">
                        <button @click.prevent="showModal = true" class="text-xs text-[#697C70] hover:underline flex items-center gap-1 mt-2 font-medium">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                            View Attachment
                        </button>

                        <template x-teleport="body">
                            <div x-show="showModal" style="display: none;" class="fixed inset-0 z-[9999] flex items-center justify-center p-4 sm:p-8" x-transition.opacity>
                                <!-- Blurred background -->
                                <div class="absolute inset-0 bg-[#2D3536]/80 backdrop-blur-md" @click="showModal = false"></div>
                                
                                <!-- Modal Box -->
                                <div class="relative bg-white rounded-xl shadow-2xl max-w-2xl w-full flex flex-col overflow-hidden" x-transition>
                                    
                                    <!-- Header with Cross Button -->
                                    <div class="flex justify-between items-center p-4 border-b border-[#B3C9D6]/20 bg-white">
                                        <h3 class="font-semibold text-[#2D3536]">Attached Image</h3>
                                        <button @click="showModal = false" class="text-gray-400 hover:text-red-500 bg-gray-100 hover:bg-red-50 p-1.5 rounded-md transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                    
                                    <!-- Image Container (Constrained Size) -->
                                    <div class="p-6 flex justify-center bg-[#FDFDFC]">
                                        <img src="/file/{{ $task->attachment_path }}" alt="Attachment" class="max-w-full max-h-[60vh] object-contain rounded-lg shadow-sm border border-[#B3C9D6]/20">
                                    </div>
                                    
                                </div>
                            </div>
                        </template>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="flex items-center justify-between sm:justify-end gap-4 w-full sm:w-auto mt-2 sm:mt-0">
        <span class="text-xs px-2.5 py-1 rounded-md font-medium flex items-center gap-1.5 {{ $badgeColor }}">
            {!! $catIcon !!}
            {{ $task->category ?? 'Personal' }}
        </span>
        <div class="flex items-center gap-2 transition">
            <a href="{{ route('tasks.edit', $task) }}" class="text-[#B3C9D6] hover:text-[#697C70] transition p-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            </a>
            <button wire:click="deleteTask({{ $task->id }})" wire:confirm="Are you sure you want to delete this task?" class="text-[#B3C9D6] hover:text-red-500 transition p-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </button>
        </div>
    </div>
</div>
