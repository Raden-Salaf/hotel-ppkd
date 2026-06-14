@extends('layouts.admin')
@section('title', 'Manajemen Kamar')
@section('subtitle', 'Status ketersediaan kamar Grand Paijo\'s Nusantara Hotel')

@section('topbar-actions')
<a href="{{ route('admin.rooms.create') }}"
   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold text-white transition-all duration-200 hover:opacity-90 active:scale-95"
   style="background: linear-gradient(135deg, #7C3AED, #4F46E5)">
    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
    </svg>
    Tambah Kamar
</a>
@endsection

@section('content')

{{-- Filter --}}
<div class="flex items-center gap-3 mb-5">
    <form method="GET" class="flex items-center gap-2">
        <select name="floor" onchange="this.form.submit()"
                class="text-sm px-3 py-2 rounded-xl border border-gray-200 dark:border-white/10
                       bg-white dark:bg-white/5 text-gray-700 dark:text-white/70
                       focus:outline-none focus:ring-2 focus:ring-purple-500/30">
            <option value="">Semua Lantai</option>
            @foreach($floors as $floor)
            <option value="{{ $floor }}" {{ request('floor') == $floor ? 'selected' : '' }}>
                Lantai {{ $floor }}
            </option>
            @endforeach
        </select>
        <select name="status" onchange="this.form.submit()"
                class="text-sm px-3 py-2 rounded-xl border border-gray-200 dark:border-white/10
                       bg-white dark:bg-white/5 text-gray-700 dark:text-white/70
                       focus:outline-none focus:ring-2 focus:ring-purple-500/30">
            <option value="">Semua Status</option>
            <option value="available"   {{ request('status') == 'available'   ? 'selected' : '' }}>Tersedia</option>
            <option value="occupied"    {{ request('status') == 'occupied'    ? 'selected' : '' }}>Terisi</option>
            <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
        </select>
    </form>

    {{-- Legend --}}
    <div class="ml-auto flex items-center gap-4 text-xs text-gray-500 dark:text-white/40">
        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>Tersedia ({{ $rooms->where('status','available')->count() }})</span>
        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-red-400"></span>Terisi ({{ $rooms->where('status','occupied')->count() }})</span>
        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>Maintenance ({{ $rooms->where('status','maintenance')->count() }})</span>
    </div>
</div>

{{-- Room Grid --}}
<div class="grid grid-cols-4 gap-4">
    @forelse($rooms as $room)
    @php
    $style = match($room->status) {
        'available'   => ['card' => 'border-purple-200 dark:border-purple-500/30 bg-white dark:bg-purple-500/8',  'badge' => 'bg-purple-50 dark:bg-purple-500/20 text-purple-700 dark:text-purple-300', 'dot' => 'bg-purple-500', 'label' => 'Tersedia'],
        'occupied'    => ['card' => 'border-red-200 dark:border-red-500/30 bg-white dark:bg-red-500/8',           'badge' => 'bg-red-50 dark:bg-red-500/20 text-red-700 dark:text-red-300',           'dot' => 'bg-red-400',    'label' => 'Terisi'],
        'maintenance' => ['card' => 'border-amber-200 dark:border-amber-500/30 bg-white dark:bg-amber-500/8',     'badge' => 'bg-amber-50 dark:bg-amber-500/20 text-amber-700 dark:text-amber-300',   'dot' => 'bg-amber-400',  'label' => 'Maintenance'],
        default       => ['card' => 'border-gray-200 bg-white', 'badge' => 'bg-gray-100 text-gray-500', 'dot' => 'bg-gray-400', 'label' => '-'],
    };
    @endphp
    <div class="border rounded-2xl p-4 {{ $style['card'] }} hover:shadow-md transition-all duration-200 group">
        <div class="flex items-start justify-between mb-3">
            <div>
                <div class="text-xl font-bold text-gray-800 dark:text-white">{{ $room->room_number }}</div>
                <div class="text-xs text-gray-400 dark:text-white/30 mt-0.5">Lantai {{ $room->floor }}</div>
            </div>
            <span class="flex items-center gap-1.5 text-xs px-2.5 py-1 rounded-full font-medium {{ $style['badge'] }}">
                <span class="w-1.5 h-1.5 rounded-full {{ $style['dot'] }}"></span>
                {{ $style['label'] }}
            </span>
        </div>
        <div class="text-sm font-medium text-gray-600 dark:text-white/60 mb-4">
            {{ $room->roomType->name }}
        </div>
        <div class="text-xs text-gray-400 dark:text-white/30 mb-4">
            Rp {{ number_format($room->roomType->price_per_night, 0, ',', '.') }}/malam
        </div>
        <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
            <a href="{{ route('admin.rooms.edit', $room) }}"
               class="flex-1 text-center text-xs py-1.5 rounded-lg border border-purple-200 dark:border-purple-500/30
                      text-purple-600 dark:text-purple-400 hover:bg-purple-50 dark:hover:bg-purple-500/10
                      transition-colors duration-150">
                Edit
            </a>
            <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}"
                  onsubmit="return confirm('Hapus kamar {{ $room->room_number }}?')">
                @csrf @method('DELETE')
                <button type="submit"
                        class="px-3 text-xs py-1.5 rounded-lg border border-red-200 dark:border-red-500/30
                               text-red-500 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10
                               transition-colors duration-150">
                    Hapus
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-4 py-16 text-center text-gray-400 dark:text-white/25">
        <p class="text-sm">Belum ada kamar. <a href="{{ route('admin.rooms.create') }}" class="text-purple-500 hover:underline">Tambah sekarang</a></p>
    </div>
    @endforelse
</div>

@endsection