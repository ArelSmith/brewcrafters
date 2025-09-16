<x-filament-panels::page>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="col-span-1">
            {{-- Small profile card --}}
            <div class="p-4 border rounded-lg">
                <div class="flex items-center gap-4">
                    @if(auth()->user()->image)
                        <img src="{{ asset(auth()->user()->image) }}" alt="avatar" class="w-16 h-16 rounded-full object-cover" width="250" />
                    @else
                        <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center">A</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-span-2">
            {{-- Render the Filament form --}}
            <div class="p-4 border rounded-lg">
                {{ $this->form }}
                <div class="mt-4">
                    <x-filament::button wire:click="save">Save changes</x-filament::button>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
