<x-filament-panels::page>
    {{-- <img src="{{ $this->form->getState()['image'] }}" alt="User Image"> --}}
    <form wire:submit.prevent="submit">
        {{ $this->form }}

        <button type="submit" class="filament-button filament-button-size-sm inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700">
            Save
        </button>
    </form>

    @if (session('status'))
        <div class="mt-4 text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif
</x-filament-panels::page>
