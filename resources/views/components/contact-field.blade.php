@props(['name', 'type', 'autocomplete', 'maxlength', 'icon', 'required' => false])
<div class="form-field">
    <label for="{{ $name }}">{{ __('site.form.'.$name) }}@if($required) <span>*</span>@else <small>{{ __('contact.optional') }}</small>@endif</label>
    <div class="input-with-icon">
        <x-icon :name="$icon" />
        <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" autocomplete="{{ $autocomplete }}" maxlength="{{ $maxlength }}" value="{{ old($name) }}" placeholder="{{ __('contact.placeholders.'.$name) }}" @required($required) @if($errors->has($name)) aria-invalid="true" aria-describedby="{{ $name }}-error" @endif>
    </div>
    @error($name)<p class="field-error" id="{{ $name }}-error">{{ $message }}</p>@enderror
</div>
