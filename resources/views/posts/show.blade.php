<x-app-layout>
    <div class="container mx-auto py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="post mb-4 p-4 bg-white shadow rounded">
                <h1 class="text-2xl font-bold mb-4">{{ $post->title }}</h1>
                <p>{{ $post->description }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
