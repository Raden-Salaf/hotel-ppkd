@php $isEdit = isset($room); @endphp

<div>
    <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">
        Nomor Kamar
    </label>
    <input type="text" name="room_number"
           value="{{ old('room_number', $room->room_number ?? '') }}"
           placeholder="contoh: 101"
           class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                  bg-white dark:bg-white/5 text-gray-800 dark:text-white
                  placeholder:text-gray-300 dark:placeholder:text-white/20
                  focus:outline-none focus:ring-2 focus:ring-purple-500/30 focus:border-purple-400
                  transition duration-200 @error('room_number') border-red-400 @enderror">
    @error('room_number')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
</div>

<div>
    <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">
        Lantai
    </label>
    <input type="number" name="floor" min="1"
           value="{{ old('floor', $room->floor ?? '') }}"
           placeholder="1"
           class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                  bg-white dark:bg-white/5 text-gray-800 dark:text-white
                  placeholder:text-gray-300 dark:placeholder:text-white/20
                  focus:outline-none focus:ring-2 focus:ring-purple-500/30 focus:border-purple-400
                  transition duration-200 @error('floor') border-red-400 @enderror">
    @error('floor')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
</div>

<div>
    <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">
        Tipe Kamar
    </label>
    <select name="room_type_id"
            class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                   bg-white dark:bg-white/5 text-gray-800 dark:text-white
                   focus:outline-none focus:ring-2 focus:ring-purple-500/30 focus:border-purple-400
                   transition duration-200 @error('room_type_id') border-red-400 @enderror">
        <option value="">Pilih tipe kamar</option>
        @foreach($roomTypes as $type)
        <option value="{{ $type->id }}"
                {{ old('room_type_id', $room->room_type_id ?? '') == $type->id ? 'selected' : '' }}>
            {{ $type->name }} — Rp {{ number_format($type->price_per_night, 0, ',', '.') }}/malam
        </option>
        @endforeach
    </select>
    @error('room_type_id')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
</div>

<div>
    <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">
        Status
    </label>
    <select name="status"
            class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                   bg-white dark:bg-white/5 text-gray-800 dark:text-white
                   focus:outline-none focus:ring-2 focus:ring-purple-500/30
                   transition duration-200">
        <option value="available"   {{ old('status', $room->status ?? '') == 'available'   ? 'selected' : '' }}>Tersedia</option>
        <option value="occupied"    {{ old('status', $room->status ?? '') == 'occupied'    ? 'selected' : '' }}>Terisi</option>
        <option value="maintenance" {{ old('status', $room->status ?? '') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
    </select>
</div>

<div>
    <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">
        Catatan <span class="normal-case font-normal text-gray-400">(opsional)</span>
    </label>
    <textarea name="notes" rows="3" placeholder="Catatan khusus untuk kamar ini..."
              class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                     bg-white dark:bg-white/5 text-gray-800 dark:text-white
                     placeholder:text-gray-300 dark:placeholder:text-white/20
                     focus:outline-none focus:ring-2 focus:ring-purple-500/30
                     transition duration-200 resize-none">{{ old('notes', $room->notes ?? '') }}</textarea>
</div>