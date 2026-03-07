<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Models\AcademicClass;

new #[Layout('layouts.app')]
class extends Component
{
    #[Computed]
    public function classes()
    {
        return AcademicClass::with(['teachers','students'])->get();
    }

    public function deleteClasses($id)
    {
        $class = AcademicClass::findOrFail($id);
        $class->delete();

        session()->flash('message', 'Class deleted successfully.');
    }
};
?>

<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="#">Manage Classes</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <flux:text class="text-sm py-12 font-medium text-neutral-500 dark:text-neutral-400">
        Class index with teachers and students.
    </flux:text>

    
    <flux:button variant="primary" class="w-full mb-12" 
                href="{{ route('classes.create') }}" 
                wire:navigate>
                
                Add New Class
            </flux:button>
            
    <flux:table container:class="max-h-120">

    </flux:table>
    <flux:table container:class="max-h-120 w-full">

        <flux:table.columns sticky class="bg-gray-100 dark:bg-neutral-900">
            <flux:table.column align="center">Class</flux:table.column>
            <flux:table.column align="center">Teachers</flux:table.column>
            <flux:table.column align="center">Students</flux:table.column>
            <flux:table.column align="center">Actions</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>

            @foreach ($this->classes as $class)

                @php
                    $rows = max($class->teachers->count(), $class->students->count());
                    $rows = $rows === 0 ? 1 : $rows;
                @endphp

                @for ($i = 0; $i < $rows; $i++)

                    <flux:table.row :key="$class->id . '-' . $i">

                        @if ($i === 0)
                            <flux:table.cell rowspan="{{ $rows }}" class="text-center align-middle">
                                <flux:text class="text-2xl font-bold text-neutral-500 dark:text-neutral-400">
                                    {{ $class->name }}
                                </flux:text>
                            </flux:table.cell>
                        @endif

                        <flux:table.cell align="center" class="max-w-37.5 md:max-w-xs truncate" title="{{ $class->teachers[$i]->name ?? '' }}">
                            {{ $class->teachers[$i]->name ?? '-' }}
                        </flux:table.cell>

                        <flux:table.cell align="center" class="max-w-37.5 md:max-w-xs truncate" title="{{ $class->students[$i]->name ?? '' }}">
                            {{ $class->students[$i]->name ?? '-' }}
                        </flux:table.cell>

                        @if ($i === 0)
                            <flux:table.cell rowspan="{{ $rows }}" class="text-center align-middle">
                                <div class="flex justify-center">
                                    <flux:button.group>
                                        <flux:button size="xs" wire:navigate href="{{ route('classes.show', $class) }}">Detail</flux:button>
                                        <flux:button size="xs" wire:navigate href="{{ route('classes.edit', $class) }}">Edit</flux:button>
                                        <flux:button size="xs" wire:click="deleteClasses({{ $class->id }})" wire:confirm="Are you sure you want to delete this class?">Delete</flux:button>
                                    </flux:button.group>
                                </div>
                            </flux:table.cell>
                        @endif

                    </flux:table.row>

                @endfor

            @endforeach

        </flux:table.rows>

    </flux:table>

</div>