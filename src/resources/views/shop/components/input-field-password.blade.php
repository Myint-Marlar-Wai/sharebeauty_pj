@php
    declare(strict_types=1);
    assert(isset($attributes) && $attributes instanceof \Illuminate\View\ComponentAttributeBag);
@endphp
@props([
    'id' => 'password',
    'name' => 'password',
    'type' => 'password',
    'value' => '',
    'labelText' => 'パスワード',
    'placeholder' => 'パスワード',
    'autocomplete' => 'current-password',
    'inputWrapperId' => null,
    'inputClass' => 'validate',
    'fieldClass' => 'field form__field',
    'togglePasswordClass' => 'toggle_pwd form__toggle_password fa-solid fa-eye-slash',
    'labelClass' => 'label',
    'readonly' => null,
    'disabled' => null,
])
<div class="{{ $fieldClass }}">
    <label for="{{ $id }}" class="{{ $labelClass }}">{{ $labelText }}</label>
    <div class="pwd" id="{{ $inputWrapperId }}">
        <input
            type="{{ $type }}"
            id="{{ $id }}"
            name="{{ $name }}"
            value="{{ $value }}"
            class="{{ $inputClass }}"
            placeholder="{{ $placeholder }}"
            autocomplete="{{ $autocomplete }}"
            @if($readonly) readonly @endif
            @if($disabled) disabled @endif
        >
        <i class="{{ $togglePasswordClass }}"></i>
    </div>
</div>
