<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\AcademicClass;
use App\Models\Teacher;

new #[Layout('layouts.app')]
class extends Component
{
    public $name;
    public $code;
    public $description;

    public $selectedTeachers = [];

    public $teachers;

    public function mount()
    {
        $this->teachers = Teacher::orderBy('name')->get();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:12|unique:academic_classes,code',
            'description' => 'nullable|string',
            'selectedTeachers' => 'nullable|array'
        ]);

        $class = AcademicClass::create([
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description
        ]);

        $class->teachers()->sync($this->selectedTeachers);

        session()->flash('message', 'Class created successfully.');

        return $this->redirect(route('classes.index'), navigate: true);
    }
};
?>

<div>

    <flux:breadcrumbs>
        <flux:breadcrumbs.item :href="route('classes.index')" wire:navigate>Manage Classes</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="#">Create Class</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <flux:text class="text-sm py-8 font-medium text-neutral-500 dark:text-neutral-400">
        Create a new Academic Class
    </flux:text>

    <form wire:submit="save">

        <flux:card class="space-y-6 bg-transparent">

            <flux:field>
                <flux:label>Class Name</flux:label>
                <flux:input wire:model="name" placeholder="Example: Class A"/>
                <flux:description>Maximum 100 characters.</flux:description>
            </flux:field>

            <flux:field>
                <flux:label>Class Code</flux:label>
                <flux:input wire:model="code" placeholder="Example: CLS-A"/>
                <flux:description>Maximum 12 characters. Must be unique.</flux:description>
            </flux:field>

            <flux:field>
                <flux:label>Description</flux:label>
                <flux:textarea wire:model="description" rows="3"/>
                <flux:description>Optional.</flux:description>
            </flux:field>

            <flux:field>
                <flux:label>Assign Teachers</flux:label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mt-2">
                    @foreach ($teachers as $teacher)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input
                                type="checkbox"
                                value="{{ $teacher->id }}"
                                wire:model="selectedTeachers"
                                class="rounded border-gray-300"
                            >

                            <span class="text-sm">
                                {{ $teacher->name }}
                            </span>
                        </label>
                    @endforeach
                </div>
                <flux:description>Select one or more teachers to assign to this class.</flux:description>
            </flux:field>

        </flux:card>

        <div class="mt-6 flex justify-end gap-3">

            <flux:button :href="route('classes.index')" wire:navigate>
                Cancel
            </flux:button>
            <flux:button type="submit" variant="primary">
                Save Class
            </flux:button>

        </div>

    </form>

</div>