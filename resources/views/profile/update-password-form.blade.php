<x-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('') }}
    </x-slot>

    <x-slot name="description">
        {{ __('') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <div class="tag-label">
                <x-label for="current_password" value="{{ __('รหัสผ่านปัจจุบัน') }}" />
            </div>
            <x-input id="current_password" type="password" class="mt-1 block w-full"
                     wire:model="state.current_password" autocomplete="current-password" />
            <x-input-error for="current_password" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <div class="tag-label">
                <x-label for="password" value="{{ __('รหัสผ่านใหม่') }}" />
            </div>
            <x-input id="password" type="password" class="mt-1 block w-full"
                     wire:model="state.password" autocomplete="new-password" />
            <x-input-error for="password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <div class="tag-label">
                <x-label for="password_confirmation" value="{{ __('ยืนยันรหัสผ่าน') }}" />
            </div>
            <x-input id="password_confirmation" type="password" class="mt-1 block w-full"
                     wire:model="state.password_confirmation" autocomplete="new-password" />
            <x-input-error for="password_confirmation" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('บันทึกแล้ว') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="updatePassword">
            <span wire:loading.remove wire:target="updatePassword">{{ __('บันทึก') }}</span>
            <span wire:loading wire:target="updatePassword">{{ __('กำลังบันทึก...') }}</span>
        </x-button>
    </x-slot>
</x-form-section>
