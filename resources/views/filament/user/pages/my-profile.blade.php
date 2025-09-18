<x-filament-panels::page>
    <form wire:submit.prevent="submit">
        <img src="{{ $user?->image ? Storage::url($user->image) : asset('assets/default-user.jpg') }}" alt="User Image" width="250">
        {{ $this->form }}

        <button type="submit"
            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-25 transition ease-in-out duration-150 mt-4">
            Save
        </button>
    </form>


    @if (session('status'))
        <div class="mt-4 text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif


</x-filament-panels::page>
