@props(['options', 'selected' => null])

<div class="custom-select2">
    <select class="form-select" name="nama_mesin" id="nama_mesin" onchange="this.form.submit();">
        <option value="" disabled selected>Nama Mesin</option>
        @foreach ($options as $option)
        <option value="{{ $option }}" {{ old('nama_mesin', request()->input('nama_mesin')) == $option ? 'selected' : ''
            }}>
            {{ $option }}
        </option>
        @endforeach
    </select>
</div>