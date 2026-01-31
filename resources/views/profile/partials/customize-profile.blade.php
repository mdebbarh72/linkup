<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Customize Profile') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your username, or add your image and bio.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.customize') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="pseudo" :value="__('User Name')" />
            <x-text-input id="pseudo" name="pseudo" type="text" class="mt-1 block w-full" :value="old('pseudo', $user->profile->pseudo)" required autofocus autocomplete="pseudo" />
            <x-input-error class="mt-2" :messages="$errors->get('pseudo')" />
        </div>

        <div>
            <x-input-label for="bio" :value="__('Bio')" />

            <textarea
                id="bio"
                name="bio"
                rows="4"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Tell us a bit about yourself..."
            >{{ old('bio', $user->bio) }}</textarea>

            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>


        <div>
            <x-input-label for="avatar" :value="__('Profile Picture')" />

            <input
                id="avatar"
                name="lien_photo"
                type="file"
                accept="image/*"
                class="mt-1 block w-full text-sm text-gray-700
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-md file:border-0
                    file:text-sm file:font-semibold
                    file:bg-indigo-50 file:text-indigo-700
                    hover:file:bg-indigo-100"
            />

            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
