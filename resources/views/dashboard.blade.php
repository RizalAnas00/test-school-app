<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                {{-- <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" /> --}}
                <livewire:overview-stats entity-name="students"/>
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <livewire:overview-stats entity-name="teachers"/>
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <livewire:overview-stats entity-name="classes"/>
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden">
            <h1 class="text-xl font-bold tracking-tight italic py-4 text-neutral-900 dark:text-neutral-100">
                Quick Overview of Databases Data -
            </h1>
            <livewire:dashboard-table/>
        </div>
    </div>
</x-layouts::app>
