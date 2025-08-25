@props(['label', 'name', 'type' => 'text', 'placeholder' => '', 'model'])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium mb-1 text-[#1F3B70]">
        {{ $label }}
    </label>
    <div class="relative h-12 rounded-xl border border-[#D9E3F2] bg-[#F9FBFD]
                focus-within:border-[#9DB2D6] focus-within:ring-1 focus-within:ring-[#9DB2D6]">
        <flux:input
            wire:model="{{ $model }}"
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            placeholder="{{ $placeholder }}"
            autocomplete="{{ $name }}"
            class="pl-4 pr-4 w-full !h-12 !bg-transparent !ring-0 !border-0 focus:!ring-0 focus:!border-0" />
    </div>
    <flux:error name="{{ $name }}" />
</div>
