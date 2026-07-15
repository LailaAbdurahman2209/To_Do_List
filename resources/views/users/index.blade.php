<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between mb-4">
                    <form method="GET" action="{{ route('users.index') }}" id="filterForm">
                        <select name="team_id" onchange="document.getElementById('filterForm').submit()" class="border-gray-300 rounded">
                            <option value="">All Teams</option>
                            @foreach($corporateTeams as $team)
                            <option value="{{ $team->id }}" {{ request('team_id') == $team->id ? 'selected' : '' }}>
                            {{ $team->name }}
                            </option>
                            @endforeach
                        </select>
                    </form>
                    @can('manage-operations')
                    <button onclick="openUserModal()" class="px-4 py-2 bg-indigo-600 text-white rounded">Add New User</button>
                    @endcan
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs uppercase">Team</th>
                            @can('manage-operations')
                            <th class="px-6 py-3 text-right text-xs uppercase">Actions</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($users as $user)
                        <tr>
                            <td class="px-6 py-4 text-sm">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-sm">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-sm">{{ $user->currentTeam->name ?? 'Unassigned' }}</td>
                            @can('manage-operations')
                            <td class="px-8 py-6 text-right flex justify-end items-center space-x-2">
                                <button onclick="editUser({{ $user->id }})" class="inline-flex items-center justify-center px-3 py-1 border border-indigo-600 text-indigo-600 ">
                                    Edit
                                </button>
                                
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="inline-block">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center px-1 py-1 border border-red-600 text-red-600">
                                        Delete
                                    </button>
                                </form>
                            </td>
                            @endcan
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="userModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4">
        <div class="bg-white p-6 rounded-lg w-full max-w-lg">
            <form id="userForm" onsubmit="handleFormSubmit(event)">
                @csrf
                <input type="hidden" id="userId" name="userId">
                <div class="space-y-4">
                    <input type="text" id="name" name="name" placeholder="Name" required class="w-full border-gray-300 rounded">
                    <input type="email" id="email" name="email" placeholder="Email" required class="w-full border-gray-300 rounded">
                    <input type="password" id="password" name="password" placeholder="Password (leave blank to keep current)" class="w-full border-gray-300 rounded">
                    <select id="modal_team_id" name="team_id" class="w-full border-gray-300 rounded">
                        <option value="">-- Unassigned --</option>
                        @foreach($corporateTeams as $team)
                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-4 flex justify-end space-x-2">
                    <button type="button" onclick="closeUserModal()" class="px-4 py-2 border rounded">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openUserModal() { 
            document.getElementById('userForm').reset(); 
            document.getElementById('userId').value = ''; 
            document.getElementById('userModal').classList.remove('hidden'); 
        }
        
        function closeUserModal() { 
            document.getElementById('userModal').classList.add('hidden'); 
        }
        
        function editUser(id) {
            fetch(`/users/${id}/edit`)
                .then(res => res.json())
                .then(user => {
                    document.getElementById('userId').value = user.id;
                    document.getElementById('name').value = user.name;
                    document.getElementById('email').value = user.email;
                    document.getElementById('modal_team_id').value = user.team_id || '';
                    document.getElementById('userModal').classList.remove('hidden');
                });
        }
        
        async function handleFormSubmit(event) {
            event.preventDefault();
            const form = document.getElementById('userForm');
            const id = document.getElementById('userId').value;
            const formData = new FormData(form);
            if(id) formData.append('_method', 'PUT');
        
            try {
                const response = await fetch(id ? `/users/${id}` : '/users', {
                    method: 'POST',
                    body: formData,
                    headers: { 
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
        
                if (response.ok) {
                    window.location.reload();
                } else if (response.status === 422) {
                    const data = await response.json();
                    const errors = Object.values(data.errors).flat();
                    alert('Please correct the following errors:\n\n' + errors.join('\n'));
                } else {
                    alert('An unexpected error occurred. Please try again.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('A network error occurred.');
            }
        }
    </script>
</x-app-layout>