<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\AcademicClass;
use App\Models\Student;
use Livewire\Attributes\Computed;

new #[Layout('layouts.app')]
class extends Component
{
    public Student $student;

    public $name;
    public $nisn;
    public $academic_class_id;
    public $address;
    public $phone_number;
    public $age;
    public $birth_date;
    public $enrollment_date;

    public function mount(Student $student)
    {
        $this->student = $student;

        $this->name = $student->name;
        $this->nisn = $student->nisn;
        $this->academic_class_id = $student->academic_class_id;
        $this->address = $student->address;
        $this->phone_number = $student->phone_number;
        $this->age = $student->age;
        $this->birth_date = $student->birth_date?->format('Y-m-d');
        $this->enrollment_date = $student->enrollment_date?->format('Y-m-d');
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
            'nisn' => 'required|string|max:20|unique:students,nisn,' . $this->student->id,
            'address' => 'required|string|max:500',
            'academic_class_id' => 'required|exists:academic_classes,id',
            'phone_number' => 'required|string|max:20',
            'age' => 'required|integer|min:0',
            'birth_date' => 'required|date',
            'enrollment_date' => 'required|date',
        ]);

        $this->student->update([
            'name' => $this->name,
            'nisn' => $this->nisn,
            'academic_class_id' => $this->academic_class_id,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'age' => $this->age,
            'birth_date' => $this->birth_date,
            'enrollment_date' => $this->enrollment_date,
        ]);

        session()->flash('message', 'Student updated successfully.');

        return redirect()->route('students.index');
    }
};
?>

<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item :href="route('students.index')" wire:navigate>
            Manage Students
        </flux:breadcrumbs.item>

        <flux:breadcrumbs.item href="#">
            Edit Student
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <flux:text class="text-sm py-8 font-medium text-neutral-500 dark:text-neutral-400">
        Update student information.
    </flux:text>

    <form wire:submit="update" class="space-y-6">

        <flux:card class="space-y-6 bg-transparent">

            <flux:field>
                <flux:input wire:model="name" placeholder="Enter student name" label="Student's Name"/>
                <flux:description>Maximum 200 characters.</flux:description>
            </flux:field>

            <flux:field>
                <flux:input wire:model="nisn" placeholder="Enter NISN" label="NISN"/>
                <flux:description>NISN must be unique and maximum 20 characters.</flux:description>
            </flux:field>

            <flux:field>
                <flux:select wire:model="academic_class_id" label="Class">
                    <option value="">Select Class</option>

                    @foreach($this->classes as $class)
                        <option value="{{ $class->id }}">
                            {{ $class->name }}
                        </option>
                    @endforeach

                </flux:select>

                <flux:description>Select the class where the student belongs.</flux:description>
            </flux:field>

            <flux:field>
                <flux:textarea wire:model="address" placeholder="Enter address" label="Address"/>
                <flux:description>Maximum 500 characters.</flux:description>
            </flux:field>

            <flux:field>
                <flux:input type="tel" wire:model="phone_number" placeholder="Enter phone number" label="Phone Number"/>
                <flux:description>Maximum 20 characters. Example: 08123456789.</flux:description>
            </flux:field>

            <flux:field>
                <flux:input type="number" wire:model="age" label="Age"/>
                <flux:description>Enter the student's age in years.</flux:description>
            </flux:field>

            <flux:field>
                <flux:input type="date" wire:model="birth_date" label="Birth Date"/>
                <flux:description>Select the student's birth date.</flux:description>
            </flux:field>

            <flux:field>
                <flux:input type="date" wire:model="enrollment_date" label="Enrollment Date"/>
                <flux:description>Date when the student enrolled in the school.</flux:description>
            </flux:field>

        </flux:card>

        <div class="flex justify-end gap-2">

            <flux:button :href="route('students.index')" wire:navigate>
                Cancel
            </flux:button>

            <flux:button variant="primary" type="submit">
                Update Student
            </flux:button>

        </div>

    </form>

</div>