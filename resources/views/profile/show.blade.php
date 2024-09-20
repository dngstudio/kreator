<x-app-layout>
    <div class="text-center">

        <!-- Profile Image -->
        <div class="my-3 flex justify-center">
            @if($user->profile_image)
                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}'s Profile Image" class="w-24 h-24 object-cover rounded-full bg-white shadow-md">
            @else
                <img src="{{ asset('storage/profile_images/default-profile.png') }}" alt="{{ $user->name }}'s Default Profile Image" class="w-24 h-24 object-cover rounded-full bg-white shadow-md">
            @endif
        </div>


        <h1 class="text-2xl font-semibold mb-2">{{ $user->name }}'s Profile</h1>
    
        <div x-data="{ count: {{ $subscribers->count() }} }" class="mb-6">
            <span x-text="count === 1 || count % 10 === 1 ? count + ' pretplatnik' : count + ' pretplatnika'"></span>
        </div>
    
        <!-- Display success or status message -->
        @if(session('status'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-6 mx-auto max-w-md">
                {{ session('status') }}
            </div>
        @endif
    
        <!-- Subscribe/Unsubscribe button -->
        @if(Auth::check() && Auth::user()->isAn('subscriber'))
            @if(!Auth::user()->subscriptions->contains($user))
                <a href="{{ route('subscribe.page', $user->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Pretplati se</a>
            @else
                <a href="{{ route('unsubscribe.page', $user->id) }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Otkaži pretplatu</a>
            @endif
        @endif
    </div>
    

    <div class="max-w-7xl mx-auto my-6 sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                <!-- Display posts of the creator -->
                <div class="posts">
                    @if($posts->isNotEmpty())
                        <h2 class="text-xl font-semibold mb-4">Posts by {{ $user->name }}</h2>
                        @foreach($posts as $post)
                            <div class="post mb-4 p-4 bg-white shadow rounded">
                                <h3 class="text-lg font-bold">
                                    @if(Auth::check() && (Auth::user()->isAn('admin') || (Auth::user()->isAn('subscriber') && Auth::user()->subscriptions->contains($user))))
                                        <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                                    @else
                                        {{ $post->title }}
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
