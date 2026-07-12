<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-xl font-bold mb-4">Add New Task</h2>

                <form action="{{ route('todos.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <input type="text" name="description" required class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Assign To</label>
                        <select name="user_id" required class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                            @foreach (\App\Models\User::all() as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Scheduled Time</label>
                        <input type="datetime-local" name="scheduled_at" required class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                        Save Task
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>