<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Svi kreatori') }}
                </h2>
            </x-slot>

            @if($creators->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($creators as $creator)
                        <div class="creator-card p-4 bg-white shadow rounded text-center">
                            <!-- Profile Image -->
                            <div class="my-3 flex justify-center">
                                @if($creator->profile_image)
                                    <img src="{{ asset('storage/' . $creator->profile_image) }}" alt="{{ $creator->name }}'s Profile Image" class="w-24 h-24 object-cover rounded-full bg-white shadow-md">
                                @else
                                    <img src="{{ asset('storage/profile_images/default-profile.png') }}" alt="{{ $creator->name }}'s Default Profile Image" class="w-24 h-24 object-cover rounded-full bg-white shadow-md">
                                @endif
                            </div>
                            <a href="{{ route('profile.show', $creator->id) }}" class="text-blue-500 hover:underline">
                                <h2 class="text-xl font-semibold">{{ $creator->name }}</h2>
                            </a>
                            <p>{{ $creator->email }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p>Nema pronađenih kreatora.</p>
            @endif
        </div>
    </div>
</x-app-layout>
