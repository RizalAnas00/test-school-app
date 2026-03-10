<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Student;
use App\Models\Parents;
use Livewire\Attributes\Computed;

new #[Layout('layouts.app')]
class extends Component
{
    public $name;

    public $selectedStudentId;

    #[Computed]
    public function students()
    {
        return Student::whereNull('parent_id')->get();
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:200',
        ]);

        $parent = Parents::create([
            'name' => $this->name,
        ]);

        Student::where('id', $this->selectedStudentId)
            ->update(['parent_id' => $parent->id]);

        session()->flash('message', 'Parent created successfully.');

        return redirect()->route('parents.index');
    }

    public function setStudentId($studentId)
    {
        $this->selectedStudentId = $studentId;
    }
};
?>

<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item :href="route('parents.index')" wire:navigate>Manage Parents</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="#">Create New Parent</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <flux:text class="text-sm py-8 font-medium text-neutral-500 dark:text-neutral-400">
        Create a new parent record.
    </flux:text>

    <form wire:submit="store" class="space-y-6">

        <flux:card class="space-y-6 bg-transparent">
            <flux:field>
                <flux:input wire:model="name" placeholder="Enter parent name" label="Student's Name"/>
                <flux:description>Maximum 200 characters.</flux:description>
            </flux:field>
        </flux:card>

        <flux:field>
            <flux:label>Assign Student</flux:label>
            <div class="grid grid-cols-4 gap-2">
                @foreach ($this->students as $student)
                    <flux:radio.group wire:model="selectedStudentId">
                        <flux:radio :value="$student->id" :label="$student->name" />
                    </flux:radio.group>
                @endforeach
            </div>
            <flux:description>Select one student for this parent</flux:description>
        </flux:field>
        <div class="flex justify-end gap-2">
            <flux:button :href="route('parents.index')" wire:navigate>
                Cancel
            </flux:button>

            <flux:button variant="primary" type="submit">
                Save Student's Parent
            </flux:button>
        </div>

    </form>

</div>