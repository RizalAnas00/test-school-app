<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Parents;

new #[Layout('layouts.app')]
class extends Component
{
    public Parents $parent;

    public function mount(Parents $parent)
    {
        $this->parent = $parent;
    }
};
?>

<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item :href="route('parents.index')" wire:navigate>Manage Students</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="#">Parent's Detail</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <flux:text class="text-sm py-8 font-medium text-neutral-500 dark:text-neutral-400">
        Student's Parent Information
    </flux:text>

    <flux:card class="space-y-6">

        <flux:field>
            <flux:label>Name</flux:label>
            <flux:text>{{ $parent->name }}</flux:text>
        </flux:field>

        <flux:field>
            <flux:label>Parent Of</flux:label>
            <flux:text>{{ $parent->student->name ?? '-' }}</flux:text>
        </flux:field>

    </flux:card>

    <div class="mt-6 flex justify-end">
        <flux:button :href="route('parents.index')" wire:navigate>
            Back
        </flux:button>
    </div>

</div>
