@php
    declare(strict_types=1);
    assert(isset($attributes) && $attributes instanceof \Illuminate\View\ComponentAttributeBag);
@endphp
@props([
    'id' => 'email',
    'name' => 'email',
    'type' => 'email',
    'value' => '',
    'labelText' => 'メールアドレス',
    'placeholder' => '例）info@sharingbeauty.co.jp',
    'autocomplete' => 'username',
    'inputClass' => 'validate',
    'fieldClass' => 'field form__field',
    'labelClass' => 'label',
    'readonly' => null,
    'disabled' => null,
])
<div class="{{ $fieldClass }}">
    <label for="{{ $id }}" class="label">{{ $labelText }}</label>
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
</div>
