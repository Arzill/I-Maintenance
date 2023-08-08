@php
$ordering = [5, 10, 50, 100, 500];
@endphp
<select name="show" id="show" onchange="this.form.submit();" class="form-select custom-select">
    @foreach ($ordering as $item)
    <option value="{{ $item }}" {{ old('show', @$_GET['show'])==$item ? 'selected' : '' }}>
        {{ $item }}
    </option>
    @endforeach
</select>