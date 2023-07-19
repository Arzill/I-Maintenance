@php
$ordering = [5, 10, 50, 100, 500];
@endphp
<div class="form-group">
    <select name="show" id="show" onchange="this.form.submit();" {!! $attributes->merge(['class' => 'form-select
        form-select-sm']) !!}>
        @foreach ($ordering as $item)
        <option value="{{ $item }}" {{ old('show', @$_GET['show'])==$item ? 'selected' : '' }}>
            {{ $item }}
        </option>
        @endforeach
    </select>
</div>