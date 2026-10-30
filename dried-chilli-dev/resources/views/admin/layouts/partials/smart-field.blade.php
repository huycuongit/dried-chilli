@php
    $isLong = strlen($value) > 100;
    $isImage = str_contains($key, 'image') || str_contains($key, 'logo');
    $isEditor = isset($field['type']) && $field['type'] === 'editor';
    $isSelect = isset($field['type']) && $field['type'] === 'select';
    $isColor = isset($field['type']) && $field['type'] === 'color';
    
    // Smart Layout Grouping
    $colClass = 'col-md-6';
    if ($isEditor || $isImage || $isLong || str_ends_with($key, '_title') || str_ends_with($key, '_description')) {
        $colClass = 'col-12';
    }
    if (preg_match('/_icon_\d+$/', $key) || $isColor) {
        $colClass = 'col-md-3';
    } elseif (preg_match('/_title_\d+$/', $key)) {
        $colClass = 'col-md-9';
    } elseif (preg_match('/_text_\d+$/', $key)) {
        $colClass = 'col-12';
    }
@endphp
<div class="{{ $colClass }}">
    <label class="form-label" {!! (!$isImage && !$isEditor) ? 'for="'.$key.'"' : '' !!}>
        {{ $isImage ? 'Image' : \Illuminate\Support\Str::limit(strip_tags($field['label']), 90) }}
    </label>

    @if ($isImage)
        @include('admin.layouts.partials.image-upload', [
            'valueName' => $inputName, 'imageValue' => $value,
            'uploadId' => $key,
        ])
    @elseif ($isSelect)
        <select id="{{ $key }}" name="{{ $inputName }}" class="form-select">
            @foreach ($field['options'] as $optKey => $optLabel)
                <option value="{{ $optKey }}" {{ $value == $optKey ? 'selected' : '' }}>{{ $optLabel }}</option>
            @endforeach
        </select>
    @elseif ($isEditor)
        <textarea class="d-none" id="input-{{ $key }}" name="{{ $inputName }}">{{ $value }}</textarea>
        <div class="service-editor nafu-dynamic-editor" id="editor-{{ $key }}">{!! $value !!}</div>
    @elseif ($isLong)
        <textarea id="{{ $key }}"
            name="{{ $inputName }}"
            class="form-control"
            rows="4">{{ $value }}</textarea>
    @elseif ($isColor)
        <input type="color" id="{{ $key }}"
            name="{{ $inputName }}"
            class="form-control form-control-color w-100"
            value="{{ $value ?: '#2d3326' }}">
    @else
        <input id="{{ $key }}"
            name="{{ $inputName }}"
            class="form-control"
            value="{{ $value }}">
    @endif
</div>
