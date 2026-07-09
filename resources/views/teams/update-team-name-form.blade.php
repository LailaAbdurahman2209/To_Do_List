<!-- Team Owner Information -->
        <div class="col-span-6">
            <x-label value="{{ __('Team Owner') }}" />

            <div class="flex items-center mt-2">
                <!-- 1. We added ?-> to the image source and alt tag -->
                <img class="size-12 rounded-full object-cover" src="{{ $team->owner?->profile_photo_url }}" alt="{{ $team->owner?->name }}">

                <div class="ms-4 leading-tight">
                    <!-- 2. We added ?-> and a fallback 'Unknown Owner' just in case -->
                    <div class="text-gray-900">{{ $team->owner?->name ?? 'Unknown Owner' }}</div>
                    <div class="text-gray-700 text-sm">{{ $team->owner?->email ?? 'No email available' }}</div>
                </div>
            </div>
        </div>