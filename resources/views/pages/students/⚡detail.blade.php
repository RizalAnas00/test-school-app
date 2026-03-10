<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Student;

new #[Layout('layouts.app')]
class extends Component
{
    public Student $student;

    public function mount(Student $student)
    {
        $this->student = $student;
    }
};
?>

<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item :href="route('students.index')" wire:navigate>Manage Students</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="#">Student Detail</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <flux:text class="text-sm py-8 font-medium text-neutral-500 dark:text-neutral-400">
        Student Information
    </flux:text>

    <flux:card class="space-y-6">

        <flux:field>
            <flux:label>Name</flux:label>
            <flux:text>{{ $student->name }}</flux:text>
        </flux:field>

        <flux:field>
            <flux:label>Parents</flux:label>
            <flux:text>{{ $student->parent->name ?? '-' }}</flux:text>
        </flux:field>

        <flux:field>
            <flux:label>NISN</flux:label>
            <flux:text>{{ $student->nisn }}</flux:text>
        </flux:field>

        <flux:field>
            <flux:label>Class</flux:label>
            <flux:text>{{ optional($student->academicClass)->name ?? '-' }}</flux:text>
        </flux:field>

        <flux:field>
            <flux:label>Address</flux:label>
            <flux:text>{{ $student->address ?? '-' }}</flux:text>
        </flux:field>

        <flux:field>
            <flux:label>Phone Number</flux:label>
            <flux:text>{{ $student->phone_number ?? '-' }}</flux:text>
        </flux:field>

        <flux:field>
            <flux:label>Age</flux:label>
            <flux:text>{{ $student->age ?? '-' }}</flux:text>
        </flux:field>

        <flux:field>
            <flux:label>Birth Date</flux:label>
            <flux:text>{{ date_format($student->birth_date, 'F j, Y') ?? '-' }}</flux:text>
        </flux:field>

        <flux:field>
            <flux:label>Enrollment Date</flux:label>
            <flux:text>{{ date_format($student->enrollment_date, 'F j, Y') ?? '-' }}</flux:text>
        </flux:field>

    </flux:card>

    <div class="mt-6 flex justify-end">
        <flux:button :href="route('students.index')" wire:navigate>
            Back
        </flux:button>
    </div>

</div>
