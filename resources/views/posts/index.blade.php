<x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-semibold mb-6">Your Posts</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('posts.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">Add New Post</a>

        @if($posts->isEmpty())
            <p>You haven't created any posts yet.</p>
        @else
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-b">Title</th>
                        <th class="px-4 py-2 border-b">Description</th>
                        <th class="px-4 py-2 border-b">Featured Image</th>
                        <th class="px-4 py-2 border-b">Actions</th>
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
                                    No image
                                @endif
                            </td>
                            <td class="px-4 py-2 border-b">
                                <a href="{{ route('posts.edit', $post) }}" class="text-blue-500 hover:underline">Edit</a>
                                {{-- Add delete button or link here --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>
