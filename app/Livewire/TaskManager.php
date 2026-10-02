<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskManager extends Component
{
    public $title;
    public $description;
    public $category = 'Personal';
    public $priority = 'Medium';
    public $quick_note = '';
    
    public $taskIdBeingEdited = null;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category' => 'nullable|string',
        'priority' => 'nullable|string',
        'quick_note' => 'nullable|string',
    ];

    public function mount()
    {
        if (Auth::check()) {
            $this->quick_note = Auth::user()->quick_note;
        }
    }

    public function saveNote()
    {
        if (Auth::check()) {
            Auth::user()->update([
                'quick_note' => $this->quick_note
            ]);
            session()->flash('note_saved', 'Note saved successfully.');
        }
    }

    public function addTask()
    {
        $this->validate();

        Auth::user()->tasks()->create([
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category,
            'priority' => $this->priority,
        ]);

        $this->resetForm();
    }

    public function toggleComplete($taskId)
    {
        $task = Auth::user()->tasks()->find($taskId);
        if ($task) {
            $task->update(['is_completed' => !$task->is_completed]);
        }
    }

    public function deleteTask($taskId)
    {
        $task = Auth::user()->tasks()->find($taskId);
        if ($task) {
            $task->delete();
        }
    }

    public function editTask($taskId)
    {
        $task = Auth::user()->tasks()->find($taskId);
        if ($task) {
            $this->taskIdBeingEdited = $task->id;
            $this->title = $task->title;
            $this->description = $task->description;
            $this->category = $task->category;
            $this->priority = $task->priority;
        }
    }

    public function updateTask()
    {
        $this->validate();

        $task = Auth::user()->tasks()->find($this->taskIdBeingEdited);
        if ($task) {
            $task->update([
                'title' => $this->title,
                'description' => $this->description,
                'category' => $this->category,
                'priority' => $this->priority,
            ]);
        }

        $this->resetForm();
    }

    public function cancelEdit()
    {
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset(['title', 'description', 'category', 'priority', 'taskIdBeingEdited']);
        $this->category = 'Personal';
        $this->priority = 'Medium';
    }

    public function render()
    {
        return view('livewire.task-manager', [
            'tasks' => Auth::user()->tasks()->orderBy('is_completed')->latest()->get(),
        ]);
    }
}
