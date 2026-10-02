<x-app-layout>
    <div class="max-w-2xl mx-auto p-8 font-sans text-[#2D3536]">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('dashboard') }}" class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm border border-[#B3C9D6]/40 text-[#2D3536]/60 hover:bg-[#F2EFE2] hover:text-[#2D3536] transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Edit Task</h1>
                <p class="text-sm text-[#2D3536]/60">Update your task details below.</p>
            </div>
        </div>

        <div class="bg-white p-8 rounded-xl shadow-sm border border-[#B3C9D6]/30">
            <form method="POST" action="{{ route('tasks.update', $task) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-[#2D3536] mb-2">Task Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ $task->title }}" required class="w-full bg-white border border-[#B3C9D6]/40 rounded-lg shadow-sm focus:border-[#697C70] focus:ring-[#697C70] px-4 py-2.5 text-[#2D3536] text-sm">
                    @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#2D3536] mb-2">Description</label>
                    <textarea name="description" class="w-full bg-white border border-[#B3C9D6]/40 rounded-lg shadow-sm focus:border-[#697C70] focus:ring-[#697C70] px-4 py-3 text-[#2D3536] text-sm" rows="3">{{ $task->description }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#2D3536] mb-2">Due Date <span class="text-red-500">*</span></label>
                    <input type="date" name="due_date" value="{{ \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') }}" required class="w-full bg-white border border-[#B3C9D6]/40 rounded-lg shadow-sm focus:border-[#697C70] focus:ring-[#697C70] px-4 py-2.5 text-[#2D3536] text-sm">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-[#2D3536] mb-2">Category</label>
                        <select name="category" class="w-full bg-white border border-[#B3C9D6]/40 rounded-lg shadow-sm focus:border-[#697C70] focus:ring-[#697C70] px-4 py-2.5 text-[#2D3536] text-sm">
                            <option value="Personal" {{ $task->category == 'Personal' ? 'selected' : '' }}>Personal</option>
                            <option value="Work" {{ $task->category == 'Work' ? 'selected' : '' }}>Work</option>
                            <option value="Study" {{ $task->category == 'Study' ? 'selected' : '' }}>Study</option>
                            <option value="Health" {{ $task->category == 'Health' ? 'selected' : '' }}>Health</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[#2D3536] mb-2">Priority</label>
                        <select name="priority" class="w-full bg-white border border-[#B3C9D6]/40 rounded-lg shadow-sm focus:border-[#697C70] focus:ring-[#697C70] px-4 py-2.5 text-[#2D3536] text-sm">
                            <option value="Low" {{ $task->priority == 'Low' ? 'selected' : '' }}>Low</option>
                            <option value="Medium" {{ $task->priority == 'Medium' ? 'selected' : '' }}>Medium</option>
                            <option value="High" {{ $task->priority == 'High' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4 flex justify-end gap-3 border-t border-[#B3C9D6]/20">
                    <a href="{{ route('dashboard') }}" class="px-5 py-2.5 text-sm text-[#2D3536] bg-white border border-[#B3C9D6]/40 rounded-lg hover:bg-[#F2EFE2] transition shadow-sm font-medium">Cancel</a>
                    <button type="submit" class="px-6 py-2.5 text-sm text-white bg-[#2D3536] rounded-lg hover:bg-[#1F2526] transition shadow-sm font-medium">Update Task</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
