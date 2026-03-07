<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Teacher;
use App\Models\AcademicClass;
use Livewire\Attributes\Computed;

new #[Layout('layouts.app')]
class extends Component
{
    public Teacher $teacher;

    public $name;
    public $phone_number;
    public $address;
    public $birth_date;
    public $subject;
    public $academic_class_ids = [];

    public function mount(Teacher $teacher)
    {
        $this->teacher = $teacher;

        $this->name = $teacher->name;
        $this->phone_number = $teacher->phone_number;
        $this->address = $teacher->address;
        $this->birth_date = $teacher->birth_date?->format('Y-m-d');
        $this->subject = $teacher->subject;

        $this->academic_class_ids = $teacher->academicClasses()->pluck('academic_classes.id')->toArray();
    }

    #[Computed]
    public function classes()
    {
        return AcademicClass::all();
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:200',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'birth_date' => 'required|date',
            'subject' => 'required|string|max:100',
            'academic_class_ids' => 'required|array',
            'academic_class_ids.*' => 'exists:academic_classes,id',
        ]);

        $this->teacher->update([
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'birth_date' => $this->birth_date,
            'subject' => $this->subject,
        ]);

        $this->teacher->academicClasses()->sync($this->academic_class_ids);

        session()->flash('message', 'Teacher updated successfully.');

        return redirect()->route('teachers.index');
    }
};
?>

<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item :href="route('teachers.index')" wire:navigate>
            Manage Teachers
        </flux:breadcrumbs.item>

        <flux:breadcrumbs.item href="#">
            Edit Teacher
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <flux:text class="text-sm py-8 font-medium text-neutral-500 dark:text-neutral-400">
        Update teacher information.
    </flux:text>

    <form wire:submit="update" class="space-y-6">

        <flux:card class="space-y-6 bg-transparent">

            <flux:field>
                <flux:input wire:model="name" label="Teacher's Name"/>
                <flux:description>Maximum 200 characters.</flux:description>
            </flux:field>

            <flux:field>
                <flux:input type="tel" wire:model="phone_number" label="Phone Number"/>
                <flux:description>Maximum 20 characters.</flux:description>
            </flux:field>

            <flux:field>
                <flux:textarea wire:model="address" label="Address"/>
                <flux:description>Maximum 500 characters.</flux:description>
            </flux:field>

            <flux:field>
                <flux:input type="date" wire:model="birth_date" label="Birth Date"/>
                <flux:description>Enter the teacher's birth date.</flux:description>
            </flux:field>

            <flux:field>
                <flux:input wire:model="subject" label="Subject"/>
                <flux:description>Maximum 100 characters.</flux:description>
            </flux:field>

            <flux:field>
                <flux:label>Assign Classes</flux:label>

                <div class="grid grid-cols-2 gap-2">
                    @foreach ($this->classes as $class)
                        <label class="flex items-center gap-2">
                            <input type="checkbox"
                                   value="{{ $class->id }}"
                                   wire:model="academic_class_ids">
                            <span>{{ $class->name }}</span>
                        </label>
                    @endforeach
                </div>

                <flux:description>Select one or more classes for this teacher.</flux:description>
            </flux:field>

        </flux:card>

        <div class="flex justify-end gap-2">

            <flux:button :href="route('teachers.index')" wire:navigate>
                Cancel
            </flux:button>

            <flux:button variant="primary" type="submit">
                Update Teacher
            </flux:button>

        </div>

    </form>

</div>