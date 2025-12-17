@props(['id' => null, 'maxWidth' => null])

@php
    $id = $id ?: md5($attributes->wire('model'));

    $maxWidth = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
    ][$maxWidth ?? '2xl'];
@endphp

<div
    x-data="{ show: @entangle($attributes->wire('model')) }"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-show="show"
    id="{{ $id }}"
    class="jetstream-modal fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0"
    style="display: none; z-index: 99999;"
>
    <div class="fixed inset-0 transform transition-all" aria-hidden="true">
        <div
            x-show="show"
            class="absolute inset-0 bg-gray-500 opacity-75"
            style="z-index: 0;"
            x-on:click="show = false"
        ></div>
    </div>

    <div
        x-show="show"
        class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto {{ $maxWidth }}"
        style="position: relative; z-index: 1;"
        x-trap.inert.noscroll="show"
        x-on:click.stop
    >
        {{ $slot }}
    </div>
</div>


