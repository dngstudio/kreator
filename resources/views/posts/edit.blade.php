<x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-semibold mb-6">Edit Post</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form to edit the post --}}
        <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block text-gray-700">Naslov</label>
                <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring">
                @error('title')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700">Sadržaj</label>
                <textarea id="description" name="description" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring">{{ old('description', $post->description) }}</textarea>
                @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="featured_image" class="block text-gray-700">Naslovna slika</label>
                <input type="file" id="featured_image" name="featured_image" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring">
                @if($post->featured_image)
                    <img src="{{ asset('storage/featured_images/' . $post->featured_image) }}" alt="{{ $post->title }}" class="mt-4" width="150">
                @endif
            </div>

            <div class="mb-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Ažuriraj post</button>
            </div>
        </form>
    </div>
</x-app-layout>
