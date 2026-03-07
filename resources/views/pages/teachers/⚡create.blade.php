<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Teacher;
use App\Models\AcademicClass;
use Livewire\Attributes\Computed;

new #[Layout('layouts.app')]
class extends Component
{
    public $name;
    public $phone_number;
    public $address;
    public $birth_date;
    public $subject;
    public $academic_class_ids = [];

    #[Computed]
    public function classes()
    {
        return AcademicClass::all();
    }

    public function store()
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

        $teacher = Teacher::create([
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'birth_date' => $this->birth_date,
            'subject' => $this->subject,
        ]);

        $teacher->academicClasses()->sync($this->academic_class_ids);

        session()->flash('message', 'Teacher created successfully.');

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
            Create New Teacher
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <flux:text class="text-sm py-8 font-medium text-neutral-500 dark:text-neutral-400">
        Create a new teacher record.
    </flux:text>

    <form wire:submit="store" class="space-y-6">

        <flux:card class="space-y-6 bg-transparent">

            <flux:field>
                <flux:input wire:model="name" placeholder="Enter teacher name" label="Teacher's Name"/>
                <flux:description>Maximum 200 characters.</flux:description>
            </flux:field>

            <flux:field>
                <flux:input type="tel" wire:model="phone_number" placeholder="Enter phone number" label="Phone Number"/>
                <flux:description>Maximum 20 characters. Example: 08123456789.</flux:description>
            </flux:field>

            <flux:field>
                <flux:textarea wire:model="address" placeholder="Enter address" label="Address"/>
                <flux:description>Maximum 500 characters.</flux:description>
            </flux:field>

            <flux:field>
                <flux:input type="date" wire:model="birth_date" label="Birth Date"/>
                <flux:description>Select the teacher's birth date.</flux:description>
            </flux:field>

            <flux:field>
                <flux:input wire:model="subject" placeholder="Enter subject" label="Subject"/>
                <flux:description>Maximum 100 characters. Example: Mathematics.</flux:description>
            </flux:field>

            <flux:field>
                <flux:label>Assign Classes</flux:label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach ($this->classes as $class)
                        <label class="flex items-center gap-2">
                            <input type="checkbox" value="{{ $class->id }}" wire:model="academic_class_ids">
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
                Save Teacher
            </flux:button>

        </div>

    </form>

</div>