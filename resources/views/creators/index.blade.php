<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <h1 class="text-2xl font-semibold mb-6">All Creators</h1> 

            @if($creators->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($creators as $creator)
                        <div class="creator-card p-4 bg-white shadow rounded">
                            <h2 class="text-xl font-semibold">{{ $creator->name }}</h2>
                            <p>{{ $creator->email }}</p>
                            <!-- Link to the creator's profile page -->
                            <a href="{{ route('profile.show', $creator->id) }}" class="text-blue-500 hover:underline">
                                View Profile
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p>No creators found.</p>
            @endif
        </div>
    </div>
</x-app-layout>
