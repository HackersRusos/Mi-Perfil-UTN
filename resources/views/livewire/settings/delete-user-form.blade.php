<section class="mt-10 space-y-6">
    <div class="relative mb-5">
        <flux:heading>{{ __('Delete account') }}</flux:heading>
        <flux:subheading>{{ __('Delete your account and all of its resources') }}</flux:subheading>
    </div>

    <flux:modal.trigger name="confirm-user-deletion">
        <flux:button 
            variant="danger" 
            x-data 
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
            {{ __('Delete account') }}
        </flux:button>
    </flux:modal.trigger>

    <flux:modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable class="max-w-lg">
        <form wire:submit="deleteUser" class="space-y-6">
            <div>
                <flux:heading size="lg">
                    {{ __('Are you sure you want to delete your account?') }}
                </flux:heading>

                <flux:subheading>
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </flux:subheading>
            </div>

            <flux:input 
                wire:model.defer="password" 
                type="password" 
                label="{{ __('Password') }}" 
                required 
                autocomplete="current-password"
            />

            <div class="flex justify-end gap-2">
                <flux:button type="button" variant="ghost" x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </flux:button>

                <flux:button type="submit" variant="danger">
                    {{ __('Confirm') }}
                </flux:button>
            </div>
        </form>
    </flux:modal>
</section>
