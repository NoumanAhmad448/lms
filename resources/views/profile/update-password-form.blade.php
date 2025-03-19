<x-jet-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('lms::Update Password') }}
    </x-slot>

    <x-slot name="description">
        {{ __('lms::Ensure your account is using a long, random password to stay secure.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="current_password" value="{{ __('lms::Current Password') }}" />
            <x-jet-input id="current_password" type="password" class="mt-1 block w-full"
                wire:model.defer="state.current_password" autocomplete="current-password"
                placeholder="Current Password" />
            <x-jet-input-error for="current_password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="password" value="{{ __('lms::New Password') }}" />
            <x-jet-input id="password" type="password" class="mt-1 block w-full" placeholder="New Password"
                wire:model.defer="state.password" autocomplete="new-password" />
            <x-jet-input-error for="password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="password_confirmation" value="{{ __('lms::Confirm Password') }}" />
            <x-jet-input id="password_confirmation" type="password" placeholder="Confirm Password"
                class="mt-1 block w-full" wire:model.defer="state.password_confirmation" autocomplete="new-password" />
            <x-jet-input-error for="password_confirmation" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('lms::Saved.') }}
        </x-jet-action-message>

        <x-jet-button class="bg-website">
            {{ __('lms::Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
