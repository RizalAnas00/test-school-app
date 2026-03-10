<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Parents;
use App\Models\Student;
use Livewire\Attributes\Computed;

new #[Layout('layouts.app')]
class extends Component
{
    public Parents $parent;

    public $name;

    public $selectedStudentId = null;


    public function mount( Parents $parent)
    {
        $this->parent = $parent;
        $this->selectedStudentId = $parent->student->id ?? null;
        $this->name = $parent->name;
        
    }

    #[Computed]
    public function students()
    {
        return Student::whereNull('parent_id')
            ->orWhere('parent_id', $this->parent->id)
            ->get();
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:200',
        ]);

        $this->parent->update([
            'name' => $this->name,
        ]);

        Student::where('parent_id', $this->parent->id)
            ->update(['parent_id' => null]);

        if ($this->selectedStudentId) {
            Student::where('id', $this->selectedStudentId)
                ->update(['parent_id' => $this->parent->id]);
        }

        session()->flash('message', 'Parent updated successfully.');

        return redirect()->route('parents.index');
    }

    public function discardStudent()
    {
        $this->selectedStudentId = null;
        Student::where('parent_id', $this->parent->id)
            ->update(['parent_id' => null]);

        session()->flash('message', 'Student unassigned from parent successfully.');
    }
};
?>

<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item :href="route('parents.index')" wire:navigate>
            Manage Parents
        </flux:breadcrumbs.item>

        <flux:breadcrumbs.item href="#">
            Edit Student's Parent
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <flux:text class="text-sm py-8 font-medium text-neutral-500 dark:text-neutral-400">
        Update student's Parent information.
    </flux:text>

    <form wire:submit="update" class="space-y-6">

        <flux:card class="space-y-6 bg-transparent">

            <flux:field>
                <flux:input wire:model="name" placeholder="Enter parent name" label="Parent's Name"/>
                <flux:description>Maximum 200 characters.</flux:description>
            </flux:field>

            <flux:field>
                <flux:label>Parent Of</flux:label>

                <flux:select wire:model="selectedStudentId">
                    <option value=""> Select Student </option>

                    @foreach ($this->students as $student)
                        <option value="{{ $student->id }}">
                            {{ $student->name }}
                        </option>
                    @endforeach
                </flux:select>

                <flux:description>Select a student for this parent.</flux:description>
            </flux:field>
            <flux:button 
                variant="danger"
                wire:click="discardStudent"
                type="button"
            >
                Discard Assigned Student
            </flux:button>
        </flux:card>
        <div class="flex justify-end gap-2">

            <flux:button :href="route('parents.index')" wire:navigate>
                Cancel
            </flux:button>

            <flux:button variant="primary" type="submit">
                Update Student's Parent
            </flux:button>

        </div>

    </form>

</div>