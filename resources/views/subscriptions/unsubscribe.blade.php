<x-app-layout>
    <div class="container mx-auto py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Otkaži pretplatu') }}
                </h2>
            </x-slot>

            <h1 class="text-2xl font-semibold mb-6">Otkaži pretplatu na {{ $creator->name }}</h1>
            
            <p>Da li sigurno želite da otkažete pretplatu sa sadržaja korisnika {{ $creator->name }}?</p>

            <form action="{{ route('unsubscribe', $creator->id) }}" method="POST">
                @csrf
                <x-primary-button>{{ __('Potvrdi otkazivanje pretplate') }}</x-primary-button>
            </form>

            <a href="{{ route('dashboard', $creator->id) }}" class="text-blue-500 mt-4 block">Otkaži</a>
        </div>
    </div>
</x-app-layout>
 