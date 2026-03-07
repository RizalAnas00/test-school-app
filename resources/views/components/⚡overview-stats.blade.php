<?php

use Livewire\Component;

use App\Models\AcademicClass;
use App\Models\Student;
use App\Models\Teacher;

new class extends Component
{
    public $entityName;

    public $totalEntities = 0;

    public function mount(): void
    {
        switch ($this->entityName) {
            case 'students':
                $this->totalEntities = Student::count();
                break;
            case 'teachers':
                $this->totalEntities = Teacher::count();
                break;
            case 'classes':
                $this->totalEntities = AcademicClass::count();
                break;
        }
    }
};
?>

<div class="p-6 h-full">
    <div class="flex items-center justify-between">
        <flux:text class="text-sm font-medium text-neutral-500 dark:text-neutral-400">
            {{ __('Total :entity', ['entity' => Str::ucfirst($this->entityName)]) }}
        </flux:text>

        <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-neutral-100 dark:bg-white/10">
            <flux:icon 
                :name="match($this->entityName) {
                    'students' => 'user-group',
                    'teachers' => 'academic-cap',
                    'classes' => 'book-open',
                    default => 'square-3-stack-3d'
                }" 
                class="w-5 h-5 text-neutral-500 dark:text-neutral-400" 
            />
        </div>
    </div>

    <div class="mt-4">
        <flux:text class="text-6xl leading-none font-bold">
            {{ $totalEntities }}
        </flux:text>
    </div>
</div>
