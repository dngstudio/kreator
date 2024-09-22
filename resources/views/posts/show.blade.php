<x-app-layout>
    <div class="container mx-auto py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="post mb-4 p-4 bg-white shadow rounded">
                <h1 class="text-2xl font-bold mb-4">{{ $post->title }}</h1>
                <p>{{ $post->description }}</p>
            </div>
        
            <div x-data="commentBox({{ $post->id }})" class="mb-4 p-4 bg-white shadow rounded">
                <h2 class="text-2xl font-semibold">Komentari</h2>

                <template x-if="!loading">
                    <form @submit.prevent="submitComment" class="my-4">
                        <textarea 
                            x-model="comment"
                            @keydown.enter="submitOnEnter($event)" 
                            @keydown.ctrl.enter="addNewLine($event)" 
                            class="w-full p-2 border border-gray-300 rounded"
                            placeholder="Napiši komentar..."
                            rows="4"
                        ></textarea>
                        <x-primary-button>
                            {{ __('Dodaj komentar') }}
                        </x-primary-button>
                    </form>
                </template>

                <div x-show="loading">Dodavanje komentara...</div>

                <template x-for="comment in comments" :key="comment.id">
                    <div class="mt-4 p-4 bg-gray-100 rounded">
                        <div class="flex items-center justify-between">
                            <div class="flex">
                                <p class="font-bold mr-2" x-text="comment.user.name"></p>
                                <span x-show="comment.is_author" class="bg-blue-500 text-white text-xs font-semibold px-2 py-1 rounded">Autor</span>
                            </div>
                            <!-- Trash icon for admin users -->
                            <span x-show="isAdminOrAuthor(comment)" @click="deleteComment(comment.id)" class="cursor-pointer text-red-600 hover:text-red-800">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                </svg>
                            </span>
                        </div>
                        <p class="text-gray-600" x-text="comment.body"></p>
                        <p class="text-sm text-gray-500" x-text="formatDate(comment.created_at)"></p>
                    </div>
                </template>
                
            </div>
        </div>
    </div>

    <script>
        function formatDate(dateString) {
            const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
            const date = new Date(dateString);
            
            const formattedDate = date.toLocaleDateString('sr-RS', options);
            const formattedTime = date.toLocaleTimeString('sr-RS', { hour: '2-digit', minute: '2-digit', hour12: false });
            
            return `${formattedDate} u ${formattedTime}`;
        }

        function commentBox(postId) {
            return {
                comments: [],
                comment: '',
                loading: false,
                isAdminOrAuthor(comment) {
                    return {{ Auth::user()->isA('admin') ? 'true' : 'false' }} || comment.user_id === {{ Auth::user()->id }};
                },

                init() {
                    this.fetchComments();
                },

                fetchComments() {
                    fetch(`/posts/${postId}/comments`)
                        .then(response => response.json())
                        .then(data => {
                            this.comments = data.comments;
                        });
                },

                submitComment() {
                    if (this.comment.trim() === '') {
                        alert('Komentar ne može biti prazan.');
                        return;
                    }

                    this.loading = true;

                    fetch(`/posts/${postId}/comments`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ body: this.comment })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.comment) {
                            this.comments.unshift(data.comment);
                            this.comment = '';
                        } else {
                            alert(data.error);
                        }
                        this.loading = false;
                    });
                },

                deleteComment(commentId) {
                    fetch(`/posts/${postId}/comments/${commentId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            this.comments = this.comments.filter(comment => comment.id !== commentId);
                        } else {
                            alert(data.error);
                        }
                    });
                },

                submitOnEnter(event) {
                    if (!event.ctrlKey) {
                        event.preventDefault();
                        this.submitComment();
                    }
                },

                addNewLine(event) {
                    this.comment += "\n";
                    event.preventDefault();
                }
            };
        }
    </script>
</x-app-layout>
