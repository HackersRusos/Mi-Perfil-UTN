@props(['label', 'model', 'show', 'toggle', 'placeholder'])

@php
    $type = $show ? 'text' : 'password';
@endphp

<div>
    <label class="block text-sm font-medium mb-1 text-[#1F3B70]">{{ $label }}</label>
    <div class="relative h-12 rounded-xl border border-[#D9E3F2] bg-[#F9FBFD]
                focus-within:border-[#9DB2D6] focus-within:ring-1 focus-within:ring-[#9DB2D6]">
        <button type="button"
                wire:click="{{ $toggle }}"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-[#7C8FB1] hover:text-[#1F3B70] text-lg">
            {!! $show ? '👁️‍🗨️' : '👁️' !!}
        </button>
        <flux:input
            wire:model="{{ $model }}"
            type="{{ $type }}"
            placeholder="{{ $placeholder }}"
            class="pl-4 pr-12 w-full !h-12 !bg-transparent !ring-0 !border-0 focus:!ring-0 focus:!border-0" />
    </div>
    <flux:error name="{{ $model }}" />
</div>
