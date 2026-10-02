<x-app-layout>
    <div class="max-w-2xl mx-auto p-8 font-sans text-[#2D3536]">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('dashboard') }}" class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm border border-[#B3C9D6]/40 text-[#2D3536]/60 hover:bg-[#F2EFE2] hover:text-[#2D3536] transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Add New Task</h1>
                <p class="text-sm text-[#2D3536]/60">Fill in the details below to create a new task.</p>
            </div>
        </div>

        <div class="bg-white p-8 rounded-xl shadow-sm border border-[#B3C9D6]/30">
            <form method="POST" action="{{ route('tasks.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-[#2D3536] mb-2">Task Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" required class="w-full bg-white border border-[#B3C9D6]/40 rounded-lg shadow-sm focus:border-[#697C70] focus:ring-[#697C70] px-4 py-2.5 text-[#2D3536] text-sm" placeholder="e.g. Finish the Q3 report">
                    @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#2D3536] mb-2">Description</label>
                    <textarea name="description" class="w-full bg-white border border-[#B3C9D6]/40 rounded-lg shadow-sm focus:border-[#697C70] focus:ring-[#697C70] px-4 py-3 text-[#2D3536] text-sm" rows="3" placeholder="Add any additional details or notes..."></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#2D3536] mb-2">Due Date <span class="text-red-500">*</span></label>
                    <input type="date" name="due_date" required class="w-full bg-white border border-[#B3C9D6]/40 rounded-lg shadow-sm focus:border-[#697C70] focus:ring-[#697C70] px-4 py-2.5 text-[#2D3536] text-sm">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-[#2D3536] mb-2">Category</label>
                        <select name="category" class="w-full bg-white border border-[#B3C9D6]/40 rounded-lg shadow-sm focus:border-[#697C70] focus:ring-[#697C70] px-4 py-2.5 text-[#2D3536] text-sm">
                            <option value="Personal">Personal</option>
                            <option value="Work">Work</option>
                            <option value="Study">Study</option>
                            <option value="Health">Health</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[#2D3536] mb-2">Priority</label>
                        <select name="priority" class="w-full bg-white border border-[#B3C9D6]/40 rounded-lg shadow-sm focus:border-[#697C70] focus:ring-[#697C70] px-4 py-2.5 text-[#2D3536] text-sm">
                            <option value="Low">Low</option>
                            <option value="Medium" selected>Medium</option>
                            <option value="High">High</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#2D3536] mb-2">Attachment (Optional)</label>
                    <input type="file" name="attachment" accept="image/*" class="w-full bg-white border border-[#B3C9D6]/40 rounded-lg shadow-sm px-4 py-2 text-sm text-[#2D3536] file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-[#F2EFE2] file:text-[#697C70] hover:file:bg-[#E8E4D5]">
                    @error('attachment') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4 flex justify-end gap-3 border-t border-[#B3C9D6]/20">
                    <a href="{{ route('dashboard') }}" class="px-5 py-2.5 text-sm text-[#2D3536] bg-white border border-[#B3C9D6]/40 rounded-lg hover:bg-[#F2EFE2] transition shadow-sm font-medium">Cancel</a>
                    <button type="submit" class="px-6 py-2.5 text-sm text-white bg-[#2D3536] rounded-lg hover:bg-[#1F2526] transition shadow-sm font-medium">Create Task</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
