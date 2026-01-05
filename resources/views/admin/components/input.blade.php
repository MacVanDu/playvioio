<div class="col-md-6 mb-3">
    <label>{{ $label }}</label>
    <input 
        type="{{ $type ?? 'text' }}"
        name="{{ $name }}"
        class="form-control"
        value="{{ $value ?? '' }}"
        {{ isset($required) ? 'required' : '' }}
    >
</div>
