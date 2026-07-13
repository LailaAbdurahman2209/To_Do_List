<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My To-Do List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-4">
                
                <div class="flex items-center space-x-3 bg-white p-2 rounded-md shadow-sm border border-gray-200">
                    <label for="unsent_tasks" class="font-semibold text-sm text-gray-700">Tasks Pending Email:</label>
                    <select id="unsent_tasks" class="border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value=""> View Unsent Tasks </option>
                        @isset($unsentTodos)
                            @foreach($unsentTodos as $unsent)
                                <option value="{{ $unsent->id }}">
                                    {{ $unsent->description }} - For: {{ $unsent->user ? $unsent->user->name : 'Unassigned' }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                </div>

                <a href="{{ route('todos.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition shadow-sm">
                    + Add Task
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned To</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Scheduled At</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($todos as $todo)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $todo->description }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $todo->user ? $todo->user->name : 'Unassigned' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $todo->scheduled_at ? \Carbon\Carbon::parse($todo->scheduled_at)->format('M d, Y H:i') : 'N/A' }}</td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($todo->email_sent)
                                        <span class="text-green-300 font-bold flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Sent
                                        </span>
                                    @else
                                        <span class="text-gray-400 italic">Pending</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">No tasks found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>