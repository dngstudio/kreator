<x-app-layout>
        <h1 class="text-2xl font-semibold mb-6">{{ $user->name }}'s Profile</h1>

        <!-- Display success or status message -->
        @if(session('status'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-6">
                {{ session('status') }}
            </div>
        @endif

        <!-- Subscribe/Unsubscribe button -->
        @if(Auth::check() && Auth::user()->isAn('subscriber'))
            @if(!Auth::user()->subscriptions->contains($user))
                <a href="{{ route('subscribe.page', $user->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Subscribe</a>
            @else
                <a href="{{ route('unsubscribe.page', $user->id) }}" class="bg-red-500 text-white px-4 py-2 rounded mb-4">Unsubscribe</a>
            @endif
        @endif
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <!-- Display posts of the creator -->
                    <div class="posts">
                        @if($posts->isNotEmpty())
                            <h2 class="text-xl font-semibold mb-4">Posts by {{ $user->name }}</h2>
                            @foreach($posts as $post)
                                <div class="post mb-4 p-4 bg-white shadow rounded">
                                    <h3 class="text-lg font-bold">
                                        {{ $post->title }}
                                        @if(Auth::check() && Auth::user()->isAn('subscriber') && !Auth::user()->subscriptions->contains($user))
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
                                                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2"/>
                                            </svg>
                                        @endif
                                    </h3>
                                    <p>{{ $post->description }}</p>
                                </div>
                            @endforeach
                        @else
                            <p>No posts yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

</x-app-layout>
