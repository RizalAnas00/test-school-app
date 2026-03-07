<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\AcademicClass;

new #[Layout('layouts.app')]
class extends Component
{
    public AcademicClass $class;

    public function mount(AcademicClass $academicClass)
    {
        $this->class = $academicClass->load('teachers');
    }
};

?>

<div>

    <flux:breadcrumbs>
        <flux:breadcrumbs.item :href="route('classes.index')" wire:navigate>
            Manage Classes
        </flux:breadcrumbs.item>

        <flux:breadcrumbs.item href="#">
            Class Detail
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <flux:text class="text-sm py-8 font-medium text-neutral-500 dark:text-neutral-400">
        Academic Class Information
    </flux:text>

    <flux:card class="space-y-6">
        <flux:field>
            <flux:label>Class Name</flux:label>
            <flux:text>{{ $class->name }}</flux:text>
        </flux:field>

        <flux:field>
            <flux:label>Class Code</flux:label>
            <flux:text>{{ $class->code }}</flux:text>
        </flux:field>

        <flux:field>
            <flux:label>Description</flux:label>
            <flux:text>{{ $class->description ?? '-' }}</flux:text>
        </flux:field>

        <flux:field>
            <flux:label>Teachers</flux:label>
            <div class="flex flex-wrap gap-2 mt-2">
                @forelse ($class->teachers as $teacher)
                    <flux:badge color="teal" rounded icon="user">
                        {{ $teacher->name }}
                    </flux:badge>
                @empty
                    <flux:text>-</flux:text>
                @endforelse
            </div>
        </flux:field>
    </flux:card>

    <div class="mt-6 flex justify-end">
        <flux:button :href="route('classes.index')" wire:navigate>
            Back
        </flux:button>
    </div>

</div>