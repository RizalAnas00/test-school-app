<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Parents;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

new #[Layout('layouts.app')]
class extends Component
{
    use WithPagination;

    #[Computed]
    public function parents()
    {
        return Parents::with('student')->get();
    }

    public function deleteParent($parentId)
    {
        $parent = Parents::find($parentId);

        if ($parent) {
            $parent->delete();
            session()->flash('message', 'Parent deleted successfully.');
            $this->js('$wire.$refresh()');
        } else {
            session()->flash('error', 'Parent not found.');
        }
    }
};
?>

<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="#">Manage Students Parents</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <flux:text class="text-sm py-12 font-medium text-neutral-500 dark:text-neutral-400">
        Students Parents Index
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
                href="{{ route('parents.create') }}" 
                wire:navigate>
                
                Add New Students Parents
            </flux:button>
        {{-- :paginate="$this->parents" --}}
    <flux:table container:class="max-h-120" >
        
        <flux:table.columns sticky class="bg-gray-100 dark:bg-neutral-900">
            <flux:table.column align="center" >Name</flux:table.column>
            <flux:table.column align="center" >Parent Of</flux:table.column>
            <flux:table.column align="center" class="w-44">Actions</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($this->parents as $parent)
                <flux:table.row :key="$parent->id">
                        <flux:table.cell class="ml-2" align="center">
                            {{ $parent->name }}
                        </flux:table.cell>
                        <flux:table.cell align="center">
                            {{ $parent->student->name ?? '-' }}     
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:button.group>
                                <flux:button size="xs" wire:navigate href="{{ route('parents.show', $parent) }}">
                                    Detail
                                </flux:button>
                                <flux:button size="xs" wire:navigate href="{{ route('parents.edit', $parent) }}">
                                    Edit
                                </flux:button>
                                <flux:button size="xs" wire:click="deleteParent({{ $parent->id }})" wire:confirm="Are you sure you want to delete this parent?">
                                    Delete
                                </flux:button>
                            </flux:button.group>
                        </flux:table.cell>

                    </flux:table.row>
            @endforeach
        </flux:table.rows>
        
    </flux:table>
</div>