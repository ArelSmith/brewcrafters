<x-filament-panels::page>
    <form wire:submit.prevent="submit" class="max-w-md mx-auto">
        <!-- Profile Picture -->
        <div class="flex justify-center mb-6">
            <img
                src="{{ $user?->image ? Storage::url($user->image) : asset('assets/default-user.jpg') }}"
                alt="User Image"
                class="w-32 h-32 rounded-full object-cover border border-gray-600"
            >
        </div>

        <!-- Filament Form -->
        <div>
            {{ $this->form }}
        </div>

        <!-- Save Button -->
        <div class="mt-6">
            <button type="submit"
                class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded w-full">
                Save
            </button>
        </div>
    </form>

    @if (session('status'))
        <div class="mt-4 text-sm text-green-600 text-center">
            {{ session('status') }}
        </div>
    @endif
</x-filament-panels::page>
