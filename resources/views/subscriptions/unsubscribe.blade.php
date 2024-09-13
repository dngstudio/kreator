<x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-semibold mb-6">Unsubscribe from {{ $creator->name }}</h1>
        
        <p>Are you sure you want to unsubscribe from {{ $creator->name }}'s content?</p>

        <form action="{{ route('unsubscribe', $creator->id) }}" method="POST">
            @csrf
            <x-primary-button>{{ __('Confirm Unsubscription') }}</x-primary-button>
        </form>

        <a href="{{ route('unsubscribe.page', $creator->id) }}" class="text-blue-500 mt-4 block">Cancel</a>
    </div>
</x-app-layout>
