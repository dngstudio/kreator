{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Display the error message -->
            @if(session('error'))
                <div class="mt-4 p-4 bg-red-100 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

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
</x-app-layout> --}}


<x-app-layout>
    <div class="container mx-auto py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Kontrolna tabla') }}
                </h2>
            </x-slot>

            {{-- Show success message if available --}}
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Display the error message -->
            @if(session('error'))
                <div class="mt-4 p-4 bg-red-100 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Check if the user is a creator --}}
            @if(Auth::user()->isA('creator'))
                {{-- Section for creators --}}
                <div class="mt-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold text-lg mb-4 text-gray-800 dark:text-gray-200">Analitika:</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="creator-card p-4 bg-white shadow rounded text-center">
                            <h4>{{ $totalViews }}</h4>
                            <p>Ukupno pregleda</p>
                        </div>
                        <div class="creator-card p-4 bg-white shadow rounded text-center">
                            <div x-data="{ count: {{ $subscribers->count() }} }" class="mb-6">
                                <h4 x-text="count"></h4>
                                <p x-text="count === 1 || count % 10 === 1 ? ' pretplatnik' : ' pretplatnika'"></p>
                            </div>
                        </div>
                    </div>
                </div>


                

                <div class="mt-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold text-lg mb-4 text-gray-800 dark:text-gray-200">Najskorije objave:</h3>
                    @if($posts->isEmpty())
                        <p>Nema objava na ovom profilu.</p>
                    @else
                        <table class="min-w-full bg-white border border-gray-200 mb-6">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border-b">Naslov</th>
                                    <th class="px-4 py-2 border-b">Sadržaj</th>
                                    <th class="px-4 py-2 border-b">Naslovna slika</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($posts as $post)
                                    <tr>
                                        <td class="px-4 py-2 border-b">{{ $post->title }}</td>
                                        <td class="px-4 py-2 border-b">{{ Str::limit($post->description, 50) }}</td>
                                        <td class="px-4 py-2 border-b">
                                            @if($post->featured_image)
                                                <img src="{{ asset('storage/featured_images/' . $post->featured_image) }}" alt="{{ $post->title }}" width="50">
                                            @else
                                                Nema slike
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Button to view all posts --}}
                        <a href="{{ route('posts.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">Vidi sve objave</a>
                    @endif
                </div>

                {{-- Display subscribers list for creators --}}
                <div class="mt-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold text-lg mb-4 text-gray-800 dark:text-gray-200">Tvoji pretplatnici:</h3>
                    @if($subscribers && $subscribers->isEmpty())
                        <p>Još nema pretplatnika.</p>
                    @else
                        <ul class="list-disc pl-5">
                            @foreach($subscribers as $subscriber)
                                <li>{{ $subscriber->name }} ({{ $subscriber->email }})</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

            @else
                {{-- Section for subscribers --}}
                <div class="mt-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold text-lg mb-4 text-gray-800 dark:text-gray-200">Objave kreatora na koje ste pretplaćeni:</h3>
                    @if($posts->isEmpty())
                        <p>Nema objava.</p>
                    @else
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border-b">Naslov</th>
                                    <th class="px-4 py-2 border-b">Kreator</th>
                                    <th class="px-4 py-2 border-b">Datum objave</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($posts as $post)
                                    <tr>
                                        <td class="px-4 py-2 border-b">
                                            <a href="{{ route('posts.show', $post) }}" class="text-blue-500 hover:underline">{{ $post->title }}</a>
                                        </td>
                                        <td class="px-4 py-2 border-b">
                                            <a href="{{ route('profile.show', $post->user) }}" class="text-blue-500 hover:underline">{{ $post->user->name }}</a>
                                        </td>
                                        <td class="px-4 py-2 border-b">{{ $post->created_at->format('F j, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
