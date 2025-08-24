<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout 
        :heading="__('Update password')" 
        :subheading="__('Ensure your account is using a long, random password to stay secure')">

        <form wire:submit="updatePassword" class="mt-6 space-y-6">
            <flux:input
                wire:model="current_password"
                :label="__('Current Password')"
                type="password"
                required
                autocomplete="current-password"
                viewable
            />

            <flux:input
                wire:model="password"
                :label="__('New Password')"
                type="password"
                required
                autocomplete="new-password"
                viewable
            />

            <flux:input
                wire:model="password_confirmation"
                :label="__('Confirm New Password')"
                type="password"
                required
                autocomplete="new-password"
                viewable
            />

            <div class="flex items-center justify-end gap-4">
                <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>

                <x-action-message on="password-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

    </x-settings.layout>
</section>
