@can('manage-operations')
<x-form-section submit="createTeam">
	<x-slot name="title">
		{{ __('Team Details') }}
	</x-slot>
	<x-slot name="description">
		{{ __('Create a new team to collaborate with others on projects.') }}
	</x-slot>
	<x-slot name="form">
		<div class="col-span-6">
			<x-label value="{{ __('Team Owner') }}" />
			<div class="flex items-center mt-2">
				<img class="size-12 rounded-full object-cover" src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}">
				<div class="ms-4 leading-tight">
					<div class="text-gray-900">{{ $this->user->name }}</div>
					<div class="text-gray-700 text-sm">{{ $this->user->email }}</div>
				</div>
			</div>
		</div>
		<div class="col-span-6 sm:col-span-4">
			<x-label for="name" value="{{ __('Team Name') }}" />
			<x-input id="name" type="text" class="mt-1 block w-full" wire:model="state.name" autofocus />
			<x-input-error for="name" class="mt-2" />
		</div>
	</x-slot>
	<x-slot name="actions">
		<x-button>
			{{ __('Create') }}
		</x-button>
	</x-slot>
</x-form-section>
@else
<div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 text-center text-gray-500">
	<svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
		<path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
	</svg>
	<span class="block font-medium text-gray-900 mb-1">{{ __('Access Denied') }}</span>
	{{ __('You do not have permission to create teams. Only the Operations team can manage teams.') }}
</div>
@endcan