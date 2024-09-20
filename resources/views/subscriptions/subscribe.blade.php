<x-app-layout>
    <div class="container mx-auto py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Pretplati se') }}
                </h2>
            </x-slot>

            <h1 class="text-2xl font-semibold mb-6">Pretplati se na {{ $creator->name }}</h1>
            
            <p>Dobij pristup ekskluzivnom sadržaju pretplatom na {{ $creator->name }}.</p>
            <p><strong>Cena:</strong> 5€ mesečno</p> <!-- Example price; adjust as needed -->

            <form action="{{ route('subscribe', $creator->id) }}" method="POST">
                @csrf
                <x-primary-button>{{ __('Potvrdi pretplatu') }}</x-primary-button>
            </form>

            <a href="{{ route('dashboard', $creator->id) }}" class="text-blue-500 mt-4 block">Otkaži</a>
        </div>
    </div>
</x-app-layout>
 