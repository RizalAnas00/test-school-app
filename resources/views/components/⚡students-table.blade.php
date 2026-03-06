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
        return Student::with('academicClass.teacher')
        ->get()
        ->groupBy('academic_class_id');
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

    <flux:button variant="primary" class="w-full mb-8">Add New Student</flux:button>
    
    <flux:table container:class="max-h-120">
        
        <flux:table.columns sticky class="bg-white dark:bg-neutral-900">
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
                                <flux:button size="xs">Detail</flux:button>
                                <flux:button size="xs">Edit</flux:button>
                                <flux:button size="xs">Delete</flux:button>
                            </flux:button.group>
                        </flux:table.cell>

                    </flux:table.row>
                @endforeach

            @endforeach
        </flux:table.rows>
        
    </flux:table>
</div>