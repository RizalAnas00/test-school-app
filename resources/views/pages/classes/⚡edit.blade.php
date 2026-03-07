<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\AcademicClass;
use App\Models\Teacher;

new #[Layout('layouts.app')]
class extends Component
{
    public AcademicClass $class;

    public $name;
    public $code;
    public $description;

    public $selectedTeachers = [];

    public $teachers;

    public function mount(AcademicClass $academicClass)
    {
        $this->class = $academicClass;

        $this->name = $academicClass->name;
        $this->code = $academicClass->code;
        $this->description = $academicClass->description;

        $this->teachers = Teacher::orderBy('name')->get();

        $this->selectedTeachers = $academicClass->teachers->pluck('id')->toArray();
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:12|unique:academic_classes,code,' . $this->class->id,
            'description' => 'nullable|string',
            'selectedTeachers' => 'nullable|array'
        ]);

        $this->class->update([
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description
        ]);

        $this->class->teachers()->sync($this->selectedTeachers);

        session()->flash('message', 'Class updated successfully.');

        return $this->redirect(route('classes.index'), navigate: true);
    }
};

?>

<div>

    <flux:breadcrumbs>
        <flux:breadcrumbs.item :href="route('classes.index')" wire:navigate>
            Manage Classes
        </flux:breadcrumbs.item>

        <flux:breadcrumbs.item href="#">
            Edit Class
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <flux:text class="text-sm py-8 font-medium text-neutral-500 dark:text-neutral-400">
        Update Academic Class
    </flux:text>

    <form wire:submit="update">

        <flux:card class="space-y-6 bg-transparent">

            <flux:field>
                <flux:label>Class Name</flux:label>
                <flux:input wire:model="name"/>
                <flux:error name="name"/>
            </flux:field>

            <flux:field>
                <flux:label>Class Code</flux:label>
                <flux:input wire:model="code"/>
                <flux:error name="code"/>
            </flux:field>

            <flux:field>
                <flux:label>Description</flux:label>
                <flux:textarea wire:model="description" rows="3"/>
                <flux:error name="description"/>
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
                <flux:error name="selectedTeachers"/>
            </flux:field>
        </flux:card>

        <div class="mt-6 flex justify-end gap-3">
            <flux:button :href="route('classes.index')" wire:navigate>
                Cancel
            </flux:button>
            <flux:button type="submit" variant="primary">
                Update Class
            </flux:button>
        </div>

    </form>

</div>