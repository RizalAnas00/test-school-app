<?php

use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\AcademicClass;
use App\Models\Student;
use App\Models\Teacher;

new class extends Component
{
    use WithPagination;

    public $entityName = 'students';
    public $entities = ['students', 'teachers', 'classes'];

    public function updatedEntityName()
    {
        $this->resetPage();
    }

    #[Computed]
    public function paginatedData() 
    {
        switch ($this->entityName) {
            case 'students':
                return Student::with('academicClass.teachers')->paginate(10);
            case 'teachers':
                return Teacher::with('academicClasses.students')->paginate(10);
            case 'classes':
                return AcademicClass::with('teachers', 'students')->paginate(10);
            default:
                return Student::with('academicClass.teachers')->paginate(10);
        }
    }

    public function setEntityName($name)
    {
        if (in_array($name, $this->entities)) {
            $this->entityName = $name;
        }
    }
};
?>

<div>
    <flux:dropdown>
        <flux:button icon:trailing="chevron-down">{{ Str::ucfirst($entityName) }}</flux:button>

        <flux:menu>
            @foreach ($entities as $entity)
                <flux:menu.item wire:click="setEntityName('{{ $entity }}')" :current="$entityName === '{{ $entity }}'">
                    {{ __('Show :entity', ['entity' => Str::ucfirst($entity)]) }}
                </flux:menu.item>
            @endforeach
        </flux:menu>
    </flux:dropdown>

    <flux:table :paginate="$this->paginatedData">
        <flux:table.columns>
            @if ($entityName === 'students')
                <flux:table.column label="Student Name">
                    Student Name
                </flux:table.column>
                <flux:table.column label="Class Name">
                    Class Name
                </flux:table.column>
            @elseif ($entityName === 'classes')
                <flux:table.column label="Class Name">
                    Class Name
                </flux:table.column>
                <flux:table.column label="Teachers">
                    Teachers
                </flux:table.column>
                <flux:table.column label="Students">
                    Students
                </flux:table.column>
            @elseif ($entityName === 'teachers')
                <flux:table.column label="Teacher Name">
                    Teacher Name
                </flux:table.column>
                <flux:table.column label="Classes">
                    Classes
                </flux:table.column>
            @endif
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($this->paginatedData as $entity)
                <flux:table.row :key="$entity->id">
                    @if ($entityName === 'students')
                        <flux:table.cell>{{ $entity->name }}</flux:table.cell>
                        <flux:table.cell>{{ optional($entity->academicClass)->name ?: '-' }}</flux:table.cell>
                    @elseif ($entityName === 'teachers')
                        <flux:table.cell>{{ $entity->name }}</flux:table.cell>
                        <flux:table.cell>{{ $entity->academicClasses->pluck('name')->join(', ') ?: '-' }}</flux:table.cell>
                    @elseif ($entityName === 'classes')
                        <flux:table.cell>{{ $entity->name }}</flux:table.cell>
                        <flux:table.cell class="max-w-37.5 md:max-w-xs truncate">{{ $entity->teachers->pluck('name')->join(', ') ?: '-' }}</flux:table.cell>
                        <flux:table.cell class="max-w-37.5 md:max-w-xs truncate">{{ $entity->students->pluck('name')->join(', ') ?: '-' }}</flux:table.cell>
                    @endif
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>