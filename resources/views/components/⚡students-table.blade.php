<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Student;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

new #[Layout('layouts.app')]
class extends Component
{
    use WithPagination;

    #[Computed]
    public function students()
    {
        return Student::with('academicClass.teachers')
        ->get()
        ->groupBy('academic_class_id');
    }

    public function deleteStudent($studentId)
    {
        $student = Student::find($studentId);

        if ($student) {
            $student->delete();
            session()->flash('message', 'Student deleted successfully.');
            $this->js('$wire.$refresh()');
        } else {
            session()->flash('error', 'Student not found.');
        }
    }
};
?>

<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="#">Manage Students</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <flux:text class="text-sm py-12 font-medium text-neutral-500 dark:text-neutral-400">
        Student's Index grouped by their class. 
    </flux:text>    

    @if (session()->has('message'))
        <flux:card class="mb-4 border border-green-200 bg-green-50 dark:bg-green-900/20 dark:border-green-800"> 
            <div class="flex items-center justify-between text-green-700 dark:text-green-400"> 
                <div class="flex items-center gap-2">
                    <flux:icon.check-circle class="w-5 h-5"/> <span>{{ session('message') }}</span> 
                </div>
                <button onclick="this.closest('.flux-card').remove()" class="opacity-70 hover:opacity-100">
                    ✕
                </button>
            </div>
        </flux:card>
    @endif


    <flux:button variant="primary" class="w-full mb-12" 
                href="{{ route('students.create') }}" 
                wire:navigate>
                
                Add New Student
            </flux:button>
            
    <flux:table container:class="max-h-120">
        
        <flux:table.columns sticky class="bg-gray-100 dark:bg-neutral-900">
            <flux:table.column align="center" >Class</flux:table.column>
            <flux:table.column align="center" >Student's Name</flux:table.column>
            <flux:table.column align="center" class="w-44">Actions</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($this->students as $classId => $students)

                @foreach ($students as $index => $student)
                    <flux:table.row :key="$student->id">

                        @if ($index === 0)
                            <flux:table.cell rowspan="{{ count($students) }}" 
                            class="text-center ">
                                <flux:text class="text-2xl font-bold text-neutral-500 dark:text-neutral-400">
                                    {{ optional($student->academicClass)->name ?? '-' }}
                                </flux:text>
                            </flux:table.cell>
                        @endif

                        <flux:table.cell class="ml-2" align="center">
                            {{ $student->name }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:button.group>
                                <flux:button size="xs" wire:navigate href="{{ route('students.show', $student) }}">
                                    Detail
                                </flux:button>
                                <flux:button size="xs" wire:navigate href="{{ route('students.edit', $student) }}">
                                    Edit
                                </flux:button>
                                <flux:button size="xs" wire:click="deleteStudent({{ $student->id }})" wire:confirm="Are you sure you want to delete this student?">
                                    Delete
                                </flux:button>
                            </flux:button.group>
                        </flux:table.cell>

                    </flux:table.row>
                @endforeach

            @endforeach
        </flux:table.rows>
        
    </flux:table>
</div>