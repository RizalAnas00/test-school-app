<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Teacher;

new #[Layout('layouts.app')]
class extends Component
{
    public Teacher $teacher;

    public function mount(Teacher $teacher)
    {
        $this->teacher = $teacher;
    }
};
?>

<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item :href="route('teachers.index')" wire:navigate>Manage Teachers</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="#">Teacher Detail</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <flux:text class="text-sm py-8 font-medium text-neutral-500 dark:text-neutral-400">
        Teacher Information
    </flux:text>

    <flux:card class="space-y-6">

        <flux:field>
            <flux:label>Name</flux:label>
            <flux:text>{{ $teacher->name }}</flux:text>
        </flux:field>

        <flux:field>
            <flux:label>Subject</flux:label>
            <flux:text>{{ $teacher->subject ?? '-' }}</flux:text>
        </flux:field>

        <flux:field>
            <flux:label>Phone Number</flux:label>
            <flux:text>{{ $teacher->phone_number ?? '-' }}</flux:text>
        </flux:field>

        <flux:field>
            <flux:label>Address</flux:label>
            <flux:text>{{ $teacher->address ?? '-' }}</flux:text>
        </flux:field>

        <flux:field>
            <flux:label>Birth Date</flux:label>
            <flux:text>{{ date_format($teacher->birth_date, 'F j, Y') ?? '-' }}</flux:text>
        </flux:field>

        <flux:field>
            <flux:label>Classes</flux:label>
            <flux:text>
                {{ $teacher->academicClasses->pluck('name')->join(', ') ?: '-' }}
            </flux:text>
        </flux:field>

    </flux:card>

    <div class="mt-6 flex justify-end">
        <flux:button :href="route('teachers.index')" wire:navigate>
            Back
        </flux:button>
    </div>

</div>