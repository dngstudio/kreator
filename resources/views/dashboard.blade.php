<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div> --}}

            <!-- Subscribed Creators' Posts -->
            <div class="mt-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4 text-gray-800 dark:text-gray-200">Posts from Creators You’re Subscribed To:</h3>

                @if($posts->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400">No posts available from your subscriptions yet.</p>
                @else
                    @foreach($posts as $post)
                        <div class="mb-4 p-4 border-b border-gray-200 dark:border-gray-700">
                            <h4 class="text-xl font-bold">
                                <a href="{{ route('posts.show', $post->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">{{ $post->title }}</a>
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                by <a href="{{ route('profile.show', $post->user->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ $post->user->name }}</a> 
                                on {{ $post->created_at->format('F j, Y') }}
                            </p>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
