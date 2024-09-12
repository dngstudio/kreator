{{-- resources/views/all-accounts.blade.php --}}
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h1 class="text-2xl font-semibold mb-6">All Accounts</h1>

                    @if($accounts->isEmpty())
                        <p>No accounts found.</p>
                    @else
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border-b text-left">ID</th>
                                    <th class="px-4 py-2 border-b text-left">Name</th>
                                    <th class="px-4 py-2 border-b text-left">Email</th>
                                    <th class="px-4 py-2 border-b text-left">Roles</th>
                                    <th class="px-4 py-2 border-b text-left">Created At</th>
                                    <th class="px-4 py-2 border-b text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($accounts as $account)
                                    <tr>
                                        <td class="px-4 py-2 border-b">{{ $account->id }}</td>
                                        <td class="px-4 py-2 border-b">{{ $account->name }}</td>
                                        <td class="px-4 py-2 border-b">{{ $account->email }}</td>
                                        <td class="px-4 py-2 border-b">
                                            @foreach($account->roles as $role)
                                                <span class="inline-block bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-sm">{{ $role->name }}</span>
                                            @endforeach
                                        </td>
                                        <td class="px-4 py-2 border-b">{{ $account->created_at->format('Y-m-d') }}</td>
                                        <td class="px-4 py-2 border-b">
                                            {{-- Admin Edit Link --}}
                                            @if(isset($isAdmin) && $isAdmin)
                                                <a href="{{ route('profile.editUser', $account->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    @if(isset($isAdmin) && $isAdmin)
                        <div class="mt-6">
                            <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Add New User</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>



