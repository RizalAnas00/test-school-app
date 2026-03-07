<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Teacher;
use App\Models\AcademicClass;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

new #[Layout('layouts.app')]
class extends Component
{
    use WithPagination;

    #[Computed]
    public function classes()
    {
        return AcademicClass::with('teachers')->get();
    }

    public function deleteTeacher($teacherId)
    {
        $teacher = Teacher::find($teacherId);

        if ($teacher) {
            $teacher->delete();
            session()->flash('message', 'Teacher deleted successfully.');
            $this->js('$wire.$refresh()');
        } else {
            session()->flash('error', 'Teacher not found.');
        }
    }
};
?>

<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="#">Manage Teachers</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <flux:text class="text-sm py-12 font-medium text-neutral-500 dark:text-neutral-400">
        Teacher's Index grouped by their class.
    </flux:text>

    @if (session()->has('message'))
        <flux:card class="mb-4 border border-green-200 bg-green-50 dark:bg-green-900/20 dark:border-green-800">
            <div class="flex items-center justify-between text-green-700 dark:text-green-400">
                <div class="flex items-center gap-2">
                    <flux:icon.check-circle class="w-5 h-5"/> <span>{{ session('message') }}</span>
                </div>
                <button onclick="this.closest('.flux-card').remove()" class="opacity-70 hover:opacity-100">
                    ✕
                </button>
            </div>
        </flux:card>
    @endif

    <flux:button variant="primary" class="w-full mb-12"
                href="{{ route('teachers.create') }}"
                wire:navigate>
        Add New Teacher
    </flux:button>

    <flux:table container:class="max-h-120">

        <flux:table.columns sticky class="bg-gray-100 dark:bg-neutral-900">
            <flux:table.column align="center">Class</flux:table.column>
            <flux:table.column align="center">Teacher</flux:table.column>
            <flux:table.column align="center" class="w-44">Actions</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($this->classes as $class)

                @foreach ($class->teachers as $index => $teacher)
                    <flux:table.row :key="$teacher->id">

                        @if ($index === 0)
                            <flux:table.cell align="center" rowspan="{{ $class->teachers->count() }}">
                                {{ $class->name }}
                            </flux:table.cell>
                        @endif

                        <flux:table.cell align="center">
                            {{ $teacher->name }}
                        </flux:table.cell>

                        <flux:table.cell align="end">
                            <div class="flex justify-end">
                                <flux:button.group>
                                    <flux:button size="xs" wire:navigate href="{{ route('teachers.show', $teacher->id) }}">
                                        Detail
                                    </flux:button>
                                    <flux:button size="xs" wire:navigate href="{{ route('teachers.edit', $teacher->id) }}">
                                        Edit
                                    </flux:button>
                                    <flux:button size="xs" wire:click="deleteTeacher({{ $teacher->id }})" wire:confirm="Are you sure you want to delete this teacher?">
                                        Delete
                                    </flux:button>
                                </flux:button.group>
                            </div>
                        </flux:table.cell>

                    </flux:table.row>
                @endforeach

            @endforeach
        </flux:table.rows>

    </flux:table>
</div>