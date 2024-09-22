<x-app-layout>
    <div class="container mx-auto py-8">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Tvoje objave') }}
            </h2>
        </x-slot>

        <div class="max-w-7xl mx-auto my-6 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4 flex justify-between">
                <a href="{{ route('posts.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Dodaj novu objavu</a>

                {{-- Admin user filter --}}
                @if(Auth::user()->isAn('admin'))
                <form action="{{ route('posts.index') }}" method="GET" id="user-filter-form">
                    <div class="relative">
                        <select name="user_id" onchange="this.form.submit()" id="user_id" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 py-2 ps-4 pe-8 rounded">
                            <option value="">Svi kreatori</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
                @endif


                <!-- Sorting Dropdown -->
                <form action="{{ route('posts.index') }}" method="GET">
                    <select name="sort" onchange="this.form.submit()" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 py-2 ps-4 pe-8 rounded">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Najskorije</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Najstarije</option>
                        <option value="views" {{ request('sort') == 'views' ? 'selected' : '' }}>Broj pregleda</option>
                    </select>
                </form>
            </div>

            @if($posts && $posts->isEmpty())
                <p>Nema postova na tvom profilu.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($posts as $post)
                        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                            <a href="{{ route('posts.show', $post->id) }}" class="hover:underline">
                                @if($post->featured_image)
                                    <img src="{{ asset('storage/featured_images/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-32 object-cover mb-4 rounded">
                                @else
                                    <div class="w-full h-32 bg-gray-200 dark:bg-gray-700 mb-4 rounded"></div>
                                @endif
                                
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                        {{ $post->title }}
                                </h3>
                            </a>
                            <!-- Comment bubble icon with comment count -->
                            <div class="flex items-center text-gray-600 gap-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-chat-text-fill" viewBox="0 0 16 16">
                                    <path d="M16 8c0 3.866-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7M4.5 5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1zm0 2.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1zm0 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1z"/>
                                </svg>
                                <span class="text-xs">{{ $post->comments->count() }}</span>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400">{{ Str::limit($post->description, 50) }}</p>
                            <div x-data="{ count: {{ $post->views }} }" class="mb-6">
                                <span x-text="count === 1 || count % 10 === 1 ? count + ' pregled' : count + ' pregleda'"></span>
                            </div>
                            
                            
                            <div class="flex justify-between">
                                <a href="{{ route('posts.edit', $post) }}" class="text-blue-500 hover:underline">Edit</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
</x-app-layout>
