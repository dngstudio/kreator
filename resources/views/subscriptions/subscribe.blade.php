<x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-semibold mb-6">Subscribe to {{ $creator->name }}</h1>
        
        <p>Get access to exclusive content by subscribing to {{ $creator->name }}.</p>
        <p><strong>Price:</strong> $5/month</p> <!-- Example price; adjust as needed -->

        <form action="{{ route('subscribe', $creator->id) }}" method="POST">
            @csrf
            <x-primary-button>{{ __('Confirm Subscription') }}</x-primary-button>
        </form>

        <a href="{{ route('subscribe.page', $creator->id) }}" class="text-blue-500 mt-4 block">Cancel</a>
    </div>
</x-app-layout>
